SCIP version 4.0.0 [precision: 8 byte] [memory: block] [mode: optimized] [LP solver: SoPlex 3.0.0] [GitHash: a80a247]
Copyright (C) 2002-2017 Konrad-Zuse-Zentrum fuer Informationstechnik Berlin (ZIB)

External codes: 
  Readline 6.2         GNU library for command line editing (gnu.org/s/readline)
  SoPlex 3.0.0         Linear Programming Solver developed at Zuse Institute Berlin (soplex.zib.de) [GitHash: b0cccbd]
  CppAD 20160000.1     Algorithmic Differentiation of C++ algorithms developed by B. Bell (www.coin-or.org/CppAD)
  ZLIB 1.2.7           General purpose compression library by J. Gailly and M. Adler (zlib.net)
  GMP 6.0.0            GNU Multiple Precision Arithmetic Library developed by T. Granlund (gmplib.org)
  ZIMPL 3.3.4          Zuse Institute Mathematical Programming Language developed by T. Koch (zimpl.zib.de)
  ASL                  AMPL Solver Library developed by D. Gay (www.netlib.com/ampl)


number of parameters = 2139
non-default parameter settings:


read problem </tmp/at2509.nl>
============

original problem has 369 variables (188 bin, 0 int, 0 impl, 181 cont) and 526 constraints

presolving:
(round 1, fast)       196 del vars, 164 del conss, 16 add conss, 153 chg bounds, 200 chg sides, 256 chg coeffs, 0 upgd conss, 0 impls, 36 clqs
(round 2, fast)       205 del vars, 333 del conss, 16 add conss, 153 chg bounds, 200 chg sides, 256 chg coeffs, 0 upgd conss, 0 impls, 37 clqs
(round 3, fast)       245 del vars, 485 del conss, 16 add conss, 153 chg bounds, 352 chg sides, 256 chg coeffs, 0 upgd conss, 0 impls, 37 clqs
(round 4, fast)       285 del vars, 485 del conss, 16 add conss, 154 chg bounds, 352 chg sides, 256 chg coeffs, 0 upgd conss, 0 impls, 37 clqs
(round 5, exhaustive) 285 del vars, 495 del conss, 16 add conss, 154 chg bounds, 352 chg sides, 256 chg coeffs, 0 upgd conss, 0 impls, 37 clqs
(round 6, exhaustive) 285 del vars, 495 del conss, 16 add conss, 154 chg bounds, 352 chg sides, 256 chg coeffs, 39 upgd conss, 0 impls, 37 clqs
(round 7, fast)       321 del vars, 495 del conss, 16 add conss, 154 chg bounds, 352 chg sides, 256 chg coeffs, 39 upgd conss, 2 impls, 37 clqs
(round 8, fast)       357 del vars, 531 del conss, 16 add conss, 154 chg bounds, 352 chg sides, 256 chg coeffs, 39 upgd conss, 5 impls, 1 clqs
   (0.0s) probing cycle finished: starting next cycle
(round 9, exhaustive) 357 del vars, 531 del conss, 16 add conss, 155 chg bounds, 352 chg sides, 256 chg coeffs, 39 upgd conss, 13 impls, 1 clqs
(round 10, fast)       367 del vars, 542 del conss, 16 add conss, 155 chg bounds, 354 chg sides, 256 chg coeffs, 39 upgd conss, 13 impls, 0 clqs
presolving (11 rounds: 11 fast, 4 medium, 4 exhaustive):
 369 deleted vars, 542 deleted constraints, 16 added constraints, 155 tightened bounds, 0 added holes, 354 changed sides, 256 changed coefficients
 13 implications, 0 cliques
presolved problem has 0 variables (0 bin, 0 int, 0 impl, 0 cont) and 0 constraints
transformed objective value is always integral (scale: 1)
Presolving Time: 0.00

 time | node  | left  |LP iter|LP it/n| mem |mdpt |frac |vars |cons |cols |rows |cuts |confs|strbr|  dualbound   | primalbound  |  gap   
t 0.0s|     1 |     0 |     0 |     - |2315k|   0 |   - |   0 |   0 |   0 |   0 |   0 |   0 |   0 | 7.000000e+00 | 7.000000e+00 |   0.00%

SCIP Status        : problem is solved [optimal solution found]
Solving Time (sec) : 0.00
Solving Nodes      : 1
Primal Bound       : +7.00000000000000e+00 (1 solutions)
Dual Bound         : +7.00000000000000e+00
Gap                : 0.00 %

optimal solution found

optimal solution found
y [*,*,1] (tr)
:    1   2   3   4    :=
1    1   1   1   0
2    1   1   0   0
3    1   1   1   0
4    1   1   0   0
5    1   1   0   1
6    1   1   1   0
7    1   1   0   0
8    1   1   1   0
9    1   1   0   0
10   1   1   0   0
11   1   1   1   0
12   1   1   0   0
13   1   1   1   0
14   1   1   0   0
15   1   1   0   1
16   1   1   1   0
17   1   1   0   0
18   1   1   1   0
19   1   1   0   0
20   1   1   0   0

 [*,*,2] (tr)
:    1   2   3   4    :=
1    0   0   0   0
2    0   0   0   0
3    0   0   0   0
4    0   0   0   0
5    0   0   0   0
6    0   0   0   0
7    0   0   0   0
8    0   0   0   0
9    0   0   0   0
10   0   0   0   0
11   0   0   0   0
12   0   0   0   0
13   0   0   0   0
14   0   0   0   0
15   0   0   0   0
16   0   0   0   0
17   0   0   0   0
18   0   0   0   0
19   0   0   0   0
20   0   0   0   0
;

