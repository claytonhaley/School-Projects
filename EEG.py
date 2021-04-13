#!/usr/bin/env python
# coding: utf-8

# # EEG Transformations and Prediction

# ## Read Data

# In[2]:


from scipy.io import loadmat
import numpy as np
import pandas as pd

df = loadmat('dis_data/train/s1D.mat')
matrix = df['DATA']


# ## Data Cleaning/Transformation

# In[3]:


samples,time,channels = matrix.shape
new_mat = np.column_stack((np.repeat(np.arange(channels),time),matrix.reshape(channels*time, -1)))
mat_df = pd.DataFrame(new_mat)


# In[4]:


samples = []
for sample, sample_df in mat_df.groupby(mat_df[0]):
    data = pd.DataFrame(sample_df)
    samples.append(data)

for i, j in enumerate(samples):
    pd.DataFrame(samples[i])
    del samples[i][0]
    samples[i].reset_index(drop=True, inplace=True)
    samples[i] = samples[i].T


# ## Sample Plots

# In[5]:


import matplotlib.pyplot as plt
get_ipython().run_line_magic('matplotlib', 'inline')

sample_rate = 500
num_samples = 2828
seconds = num_samples/sample_rate
time_vect = np.linspace(0, seconds, num_samples)

plt.figure(figsize=(20,5))
plt.plot(time_vect, samples[0].iloc[0])


# ## Continuous Wavelet Transform

# In[6]:


import pywt
from scipy import signal
cwtmatr = signal.cwt(samples[0].iloc[0], signal.ricker, np.arange(1, 31))
plt.figure(figsize=(20,5))
plt.imshow(cwtmatr, extent=[-1, 1, 1, 31], cmap='PRGn', aspect='auto',
           vmax=abs(cwtmatr).max(), vmin=-abs(cwtmatr).max())
plt.colorbar()
plt.show()


# ## Hilbert-Huang Transform

# ### We must perform Empirical Mode Decomposition (EMD) first

# In[8]:


import emd
imf = emd.sift.sift(samples[0].iloc[0])


# ### Compute instantaneous frequency, phase and amplitude using the Normalised Hilbert Transform Method.

# In[9]:


IP,IF,IA = emd.spectra.frequency_transform(imf, sample_rate, 'nht')


# ### Compute Hilbert-Huang spectrum

# In[10]:


freq_edges,freq_bins = emd.spectra.define_hist_bins(0,3,30)
hht = emd.spectra.hilberthuang(IF, IA, freq_edges)


# In[12]:


plt.figure(figsize=(20,8))
plt.subplot(2,1,1,frameon=False)
plt.plot(time_vect,samples[0].iloc[0],'k')
plt.plot(time_vect,imf[:,0]-4,'r')
plt.plot(time_vect,imf[:,1]-8,'g')
plt.plot(time_vect,imf[:,2]-12,'b')
plt.xlim(time_vect[0], time_vect[-1])
plt.grid(True)
plt.subplot(2,1,2)
plt.pcolormesh(time_vect, freq_bins, hht, cmap='ocean_r')
plt.ylabel('Frequency (Hz)')
plt.xlabel('Time (secs)')
plt.grid(True)
plt.colorbar()
plt.show()


# # Now, I will perform the same techniques on just one subject. I will input the results into a CNN to train.

# ## Continuous Wavelet Transform

# In[10]:


signals = []
for i, j in enumerate(samples):
    for index, row in samples[i].iterrows():
        cwtmatr = signal.cwt(samples[i].iloc[index-1], signal.ricker, np.arange(1, 31))
        signals.append(cwtmatr)


# In[11]:


signals = np.asarray(signals)
signals = np.split(signals, 48)
signals = np.asarray(signals)


# In[12]:


from sklearn.decomposition import PCA

sig_comps = []

for i,j in enumerate(signals):
    for k,l in enumerate(signals[i]):
        pca_sigs = PCA(n_components=3)
        comps = pca_sigs.fit_transform(signals[i][k])
        sig_comps.append(comps)


# In[13]:


sig_comps = np.array(sig_comps)
sig_comps = np.split(sig_comps, 48)
sig_comps = np.array(sig_comps)


# In[14]:


sig_comps.shape


# ### Create images for each sample

# In[15]:


from PIL import Image

signals = np.array(signals, dtype=np.uint8)

for i,j in enumerate(sig_comps):
    img = Image.fromarray(sig_comps[i], 'RGB')
    name = 'img'+str(i)+'.png'
    img.save('/Users/claytonhaley/Desktop/STAT6650/EEG/dis_imgs/CWT/' + str(name))


# In[16]:


import glob
imgs = []
for filename in glob.glob('/Users/claytonhaley/Desktop/STAT6650/EEG/dis_imgs/CWT/*.png'):
    img=Image.open(filename)
    img = np.array(img.convert("RGB"))
    imgs.append(img)
imgs = np.array(imgs)


# In[34]:


from sklearn.model_selection import train_test_split

labels = loadmat('dis_label/train/sub1DistanceOderNum.mat')
matrix_labels = labels['dist_label']

X_train, X_test, y_train, y_test = train_test_split(imgs, matrix_labels, test_size=0.15, random_state=42)


# In[35]:


plt.figure(figsize=(5,5))
plt.xticks([])
plt.yticks([])
plt.grid(False)
plt.imshow(X_train[0], cmap=plt.cm.binary)
plt.xlabel(np.unique(matrix_labels)[y_train[0][0]])
plt.show()


# In[96]:


import tensorflow as tf
from tensorflow.keras import datasets, layers, models
import matplotlib.pyplot as plt

model = models.Sequential()
model.add(layers.Conv2D(64, (3, 3), activation='relu', input_shape=(64,30,3)))
model.add(layers.MaxPooling2D((2, 2)))
model.add(layers.Conv2D(64, (3, 3), activation='relu'))
model.add(layers.MaxPooling2D((2, 2)))
model.add(layers.Conv2D(128, (3, 3), activation='relu'))
model.add(layers.MaxPooling2D((2, 2)))
model.summary()


# In[97]:


model.add(layers.Flatten())
model.add(layers.Dense(128, activation='relu'))
model.add(layers.Dense(2))
model.summary()


# In[98]:


model.compile(optimizer='adam',
              loss=tf.keras.losses.SparseCategoricalCrossentropy(from_logits=True),
              metrics=['accuracy'])

history = model.fit(X_train[:30], y_train[:30], epochs=50, 
                    validation_data=(X_train[-10:], y_train[-10:]))


# In[99]:


plt.plot(history.history['accuracy'], label='accuracy')
plt.plot(history.history['val_accuracy'], label = 'val_accuracy')
plt.xlabel('Epoch')
plt.ylabel('Accuracy')
plt.legend(loc='lower right')

test_loss, test_acc = model.evaluate(X_test,y_test,verbose=2)


# ## Hilbert Huang Transform

# In[ ]:


signals_hht = []
for i, j in enumerate(samples):
    for index, row in samples[i].iterrows():
        imf = emd.sift.sift(samples[i].iloc[index-1])
        IP,IF,IA = emd.spectra.frequency_transform(imf, sample_rate, 'nht')
        freq_edges,freq_bins = emd.spectra.define_hist_bins(0,3,30)
        hht = emd.spectra.hilberthuang(IF, IA, freq_edges)
        signals_hht.append(hht)


# In[101]:


signals_hht = np.nan_to_num(signals_hht, copy=False, nan=0)


# In[102]:


signals_hht = np.asarray(signals_hht)
signals_hht = np.split(signals_hht, 48)
signals_hht = np.asarray(signals_hht)


# In[103]:


sig_comps_hht = []

for i,j in enumerate(signals_hht):
    for k,l in enumerate(signals_hht[i]):
        pca_sigs = PCA(n_components=3)
        comps = pca_sigs.fit_transform(signals_hht[i][k])
        sig_comps_hht.append(comps)


# In[104]:


sig_comps_hht = np.array(sig_comps_hht)
sig_comps_hht = np.split(sig_comps_hht, 48)
sig_comps_hht = np.array(sig_comps_hht)


# In[105]:


sig_comps_hht.shape


# In[106]:


signals_hht = np.array(signals_hht, dtype=np.uint8)

for i,j in enumerate(signals_hht):
    img = Image.fromarray(signals_hht[i], 'RGB')
    name = 'img'+str(i)+'.png'
    img.save('/Users/claytonhaley/Desktop/STAT6650/EEG/dis_imgs/HHT/' + str(name))


# In[107]:


imgs_hht = []
for filename in glob.glob('/Users/claytonhaley/Desktop/STAT6650/EEG/dis_imgs/HHT/*.png'):
    img=Image.open(filename)
    img = np.array(img.convert("RGB"))
    imgs_hht.append(img)
imgs_hht = np.array(imgs_hht)


# In[108]:


labels = loadmat('dis_label/train/sub1DistanceOderNum.mat')
matrix_labels = labels['dist_label']

X_train_hht, X_test_hht, y_train_hht, y_test_hht = train_test_split(imgs_hht, matrix_labels, test_size=0.15, random_state=42)


# In[110]:


plt.figure(figsize=(5,5))
plt.xticks([])
plt.yticks([])
plt.grid(False)
plt.imshow(X_train_hht[9], cmap=plt.cm.binary)
plt.xlabel(np.unique(matrix_labels)[y_train_hht[10][0]])
plt.show()


# In[92]:


model = models.Sequential()
model.add(layers.Conv2D(64, (3, 3), activation='relu', input_shape=(64, 30, 3)))
model.add(layers.MaxPooling2D((2, 2)))
model.add(layers.Conv2D(64, (3, 3), activation='relu'))
model.add(layers.MaxPooling2D((2, 2)))
model.add(layers.Conv2D(128, (3, 3), activation='relu'))
model.add(layers.MaxPooling2D((2, 2)))
model.summary()


# In[93]:


model.add(layers.Flatten())
model.add(layers.Dense(128, activation='relu'))
model.add(layers.Dense(2))
model.summary()


# In[94]:


model.compile(optimizer='adam',
              loss=tf.keras.losses.SparseCategoricalCrossentropy(from_logits=True),
              metrics=['accuracy'])

history = model.fit(X_train_hht[:30], y_train_hht[:30], epochs=70, 
                    validation_data=(X_train_hht[-10:], y_train_hht[-10:]))


# In[95]:


plt.plot(history.history['accuracy'], label='accuracy')
plt.plot(history.history['val_accuracy'], label = 'val_accuracy')
plt.xlabel('Epoch')
plt.ylabel('Accuracy')
plt.legend(loc='lower right')

test_loss, test_acc = model.evaluate(X_test_hht,y_test_hht)


# In[ ]:




