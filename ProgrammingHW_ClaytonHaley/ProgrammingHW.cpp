//====================================================================================
// Name        : ProgrammingHW.cpp
// Author      : Clayton Haley
// Description : Intro to Algorithms ProgrammingHW
// Compile     : g++ -std=c++11 ProgrammingHW.cpp
// Run         : ./a.out ProgrammingHW.cpp
// Sources     : For lines 73-77, 102-106, 131-135, 151-155, 171-175, I used
//                "https://www.geeksforgeeks.org/measure-execution-time-function-cpp/"
//                 in order to learn how to measure execution time of a function.
//               For lines 207-209, I used
//                "https://www.geeksforgeeks.org/generating-random-number-range-c/"
//                  in order to learn how to generate random negative, positive, and
//                  zero numbers
//====================================================================================
#include <fstream>
#include <iostream>
#include <cstdlib>
#include <sstream>
#include <vector>
#include <ctime>
#include <chrono>
#include <algorithm>

using namespace std;
using namespace std::chrono;

const int NUM_RUNS = 500;
const int R = 19;
const int C = 8;

// Prototypes
int r();
vector<int> read_file(string file);
bool check_file(string file);
void write_file(string file, int mat[R][C]);
int Algorithm1(vector<int> X);
int Algorithm2(vector<int> X);
int Algorithm3(vector<int> X, int L, int U);
int Algorithm4(vector<int> X);


int main() {
      srand(time(0));
      vector<int> myArray;
      int matrix[R][C];

      // Read from file of comman delimited integers and create an
      // array containing these integers
      if (!check_file("phw_input.txt")) {
            cout << "Input file opening failed." << endl;
      }
      myArray = read_file("phw_input.txt");
      int front = 0;
      int end = myArray.size()-1;

      // Run each algorithm on input array and print out answers
      cout << "algorithm-1: " << Algorithm1(myArray) << " "
            << "algorithm-2: " << Algorithm2(myArray) << " "
            << "algorithm-3: " << Algorithm3(myArray,front,end) << " "
            << "algorithm-4: " << Algorithm4(myArray)
            << endl;
      cout << endl;

      cout << "algorithm-1,algorithm-2,algorithm-3,algorithm-4,"
            << "T1(n),T2(n),T3(n),T4(n)\n" << endl;
      // Create 19 integer sequences of length 10,15,20,25...100, containing
      // randomly generated negative, zero, and positive integers. Measure running time for
      // each of the algorithms executing on each of the 19 input arrays to fill the first four columns of a
      // 19X8 matrix of integers with average execution times.

      // Avg running times - Algorithm1
      int cap = 10;
      int elapsed;
      int y = 0;
      int avg = 0;
      for (int j = 0; j < R; j++) {
            vector<int> v(cap);
            generate(v.begin(), v.end(), r);
            for (int i = 0; i < NUM_RUNS; i++) {
                  auto start = chrono::high_resolution_clock::now();
                  Algorithm1(v);
                  auto end = chrono::high_resolution_clock::now();

                  elapsed = chrono::duration_cast<chrono::nanoseconds>(end - start).count();
                  avg += elapsed;
            }
            avg = avg / NUM_RUNS;
            matrix[j][y] = avg;
            cap += 5;
      }

      // Theoretical T(n) - A1
      int n = 10;
      int result;
      y = 4;
      for (int k = 0; k < R; k++) {
            result = ((11*(n*n*n))/2) + (9*(n*n)) + ((13*n)/2) + 3;
            matrix[k][y] = result;
            n += 5;
      }

      // Avg running times - Algorithm2
      cap = 10;
      y = 1;
      for (int j = 0; j < R; j++) {
            vector<int> v(cap);
            generate(v.begin(), v.end(), r);
            for (int i = 0; i < NUM_RUNS; i++) {
                  auto start = chrono::high_resolution_clock::now();
                  Algorithm2(v);
                  auto end = chrono::high_resolution_clock::now();

                  elapsed = chrono::duration_cast<chrono::nanoseconds>(end - start).count();
                  avg += elapsed;
            }
            avg = avg / NUM_RUNS;
            matrix[j][y] = avg;
            cap += 5;
      }
      // Theoretical T(n) - A2
      n = 10;
      y = 5;
      for (int k = 0; k < R; k++) {
            result = ((11*(n*n))/2) + ((3*n)/2) + 3;
            matrix[k][y] = result;
            n += 5;
      }

      // Avg running times - Algorithm3
      cap = 10;
      y = 2;
      for (int j = 0; j < R; j++) {
            vector<int> v(cap);
            generate(v.begin(), v.end(), r);
            int front = 0;
            int last = v.size()-1;
            for (int i = 0; i < NUM_RUNS; i++) {
                  auto start = chrono::high_resolution_clock::now();
                  Algorithm3(v, front, last);
                  auto end = chrono::high_resolution_clock::now();

                  elapsed = chrono::duration_cast<chrono::nanoseconds>(end - start).count();
                  avg += elapsed;
            }
            avg = avg / NUM_RUNS;
            matrix[j][y] = avg;
            cap += 5;
      }
      // Theoretical T(n) - A3
      n = 10;
      y = 6;
      for (int k = 0; k < R; k++) {
            result = (50*n) - 47;
            matrix[k][y] = result;
            n += 5;
      }

      // Avg running times - Algorithm4
      cap = 10;
      y = 3;
      for (int j = 0; j < R; j++) {
            vector<int> v(cap);
            generate(v.begin(), v.end(), r);
            for (int i = 0; i < NUM_RUNS; i++) {
                  auto start = chrono::high_resolution_clock::now();
                  Algorithm4(v);
                  auto end = chrono::high_resolution_clock::now();

                  elapsed = chrono::duration_cast<chrono::nanoseconds>(end - start).count();
                  avg += elapsed;
            }
            avg = avg / NUM_RUNS;
            matrix[j][y] = avg;
            cap += 5;
      }

      // Theoretical T(n) - A4
      n = 10;
      y = 7;
      for (int k = 0; k < R; k++) {
            result = (12*n) + 4;
            matrix[k][y] = result;
            n += 5;
      }

      for (int i = 0; i < R; i++) {
            for (int j = 0; j < C; j++) {
                  cout << matrix[i][j] << ",";
            }
            cout << endl;
      }

      // write matrix to file
      write_file("claytonhaley_phw_output.txt", matrix);
}

// Random number generator for range -1000..1000
int r() {
      int random = (rand() % (1000 - (-1000) + 1)) + -1000;
      return random;
}

// Read input file
vector<int> read_file(string file) {
      ifstream stream;
      vector<int> v;
      string line;

      stream.open(file.c_str());
      getline(stream, line);

      stringstream ss(line);
      string s;
      while (getline(ss, s, ',')) {
            stringstream fs(s);
            int i = 0;
            fs >> i;

            v.push_back(i);
      }

      stream.close();
      return v;
}

// Check if valid file
bool check_file(string file) {
      /* Input file stream. (ifstream) */
      ifstream stream;

      /* Check whether file exists. */
      stream.open(file.c_str());
      if (stream.fail()) {
            return false;
      }
      stream.close();
      return true;
}

// Write output file
void write_file(string file, int mat[R][C]) {
      ofstream stream;

      stream.open(file.c_str());
      stream << "algorithm-1,algorithm-2,algorithm-3,algorithm-4,"
            << "T1(n),T2(n),T3(n),T4(n)" << endl;
      for (int i = 0; i < R; i++) {
            for (int j = 0; j < C; j++) {
                  stream << mat[i][j] << ",";
            }
            stream << endl;
      }
      stream.close();
}

int Algorithm1(vector<int> X) {
      unsigned short L;
      unsigned short U;
      unsigned short I;
      int sum;
      int maxSoFar = 0;
      for (L = 0; L < X.size(); L++) {
            for (U = L; U < X.size(); U++) {
                  sum = 0;
                  for (I = L; I < U; I++) {
                        sum = sum + X[I];
                  }
                  maxSoFar = max(maxSoFar, sum);
            }
      }
      return maxSoFar;
}

int Algorithm2(vector<int> X) {
      int maxSoFar = 0;
      int sum;
      unsigned short L;
      unsigned short U;
      for (L = 0; L < X.size(); L++) {
            sum = 0;
            for (U = L; U < X.size(); U++) {
                  sum = sum + X.at(U);
                  maxSoFar = max(maxSoFar, sum);
            }
      }
      return maxSoFar;
}

int Algorithm3(vector<int> X, int L, int U) {
      int M;
      int sum;
      int maxToLeft;
      int maxToRight;
      int maxCrossing;
      int maxInA;
      int maxInB;
      int max1;
      int result;

      if (L > U) {
            return 0;
      }
      if (L == U) {
            return max(0, X.at(L));
      }
      M = (L+U)/2;
      sum = 0;
      maxToLeft = 0;
      for (unsigned short I = M; I > L; I--) {
            sum = sum + X.at(I);
            maxToLeft = max(maxToLeft, sum);
      }
      sum = 0;
      maxToRight = 0;
      for (unsigned short I = M + 1; I < U; I++) {
            sum = sum + X.at(I);
            maxToRight = max(maxToRight, sum);
      }
      maxCrossing = maxToLeft + maxToRight;
      maxInA = Algorithm3(X,L,M);
      maxInB = Algorithm3(X,M+1,U);
      max1 = max(maxCrossing, maxInA);
      result = max(max1, maxInB);
      return result;
}

int Algorithm4(vector<int> X) {
      int maxSoFar = 0;
      int maxEndingHere = 0;
      unsigned short I;
      for (I = 0; I < X.size(); I++) {
            maxEndingHere = max(0, (maxEndingHere + X.at(I)));
            maxSoFar = max(maxSoFar, maxEndingHere);
      }
      return maxSoFar;
}
