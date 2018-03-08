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


read problem </tmp/at2887.nl>
============

original problem has 525 variables (264 bin, 0 int, 0 impl, 261 cont) and 778 constraints

presolving:
(round 1, fast)       212 del vars, 164 del conss, 0 add conss, 209 chg bounds, 312 chg sides, 420 chg coeffs, 0 upgd conss, 0 impls, 136 clqs
(round 2, fast)       225 del vars, 165 del conss, 0 add conss, 209 chg bounds, 540 chg sides, 648 chg coeffs, 0 upgd conss, 0 impls, 137 clqs
(round 3, fast)       225 del vars, 165 del conss, 0 add conss, 330 chg bounds, 540 chg sides, 648 chg coeffs, 0 upgd conss, 0 impls, 137 clqs
(round 4, fast)       285 del vars, 621 del conss, 0 add conss, 330 chg bounds, 936 chg sides, 648 chg coeffs, 0 upgd conss, 0 impls, 137 clqs
(round 5, exhaustive) 285 del vars, 631 del conss, 0 add conss, 330 chg bounds, 936 chg sides, 648 chg coeffs, 0 upgd conss, 0 impls, 137 clqs
(round 6, exhaustive) 285 del vars, 631 del conss, 0 add conss, 330 chg bounds, 936 chg sides, 648 chg coeffs, 139 upgd conss, 0 impls, 137 clqs
   (0.0s) probing cycle finished: starting next cycle
presolving (7 rounds: 7 fast, 3 medium, 3 exhaustive):
 285 deleted vars, 631 deleted constraints, 0 added constraints, 331 tightened bounds, 0 added holes, 936 changed sides, 648 changed coefficients
 2 implications, 2873 cliques
presolved problem has 240 variables (239 bin, 0 int, 1 impl, 0 cont) and 147 constraints
      2 constraints of type <varbound>
    137 constraints of type <setppc>
      8 constraints of type <linear>
transformed objective value is always integral (scale: 1)
Presolving Time: 0.02

 time | node  | left  |LP iter|LP it/n| mem |mdpt |frac |vars |cons |cols |rows |cuts |confs|strbr|  dualbound   | primalbound  |  gap   
k 0.0s|     1 |     0 |     0 |     - |4471k|   0 |   - | 240 | 146 | 240 | 145 |   0 |   1 |   0 | 1.200000e+02 | 1.200000e+02 |   0.00%

SCIP Status        : problem is solved [optimal solution found]
Solving Time (sec) : 0.02
Solving Nodes      : 1
Primal Bound       : +1.20000000000000e+02 (1 solutions)
Dual Bound         : +1.20000000000000e+02
Gap                : 0.00 %

optimal solution found

optimal solution found
y [*,*,1] (tr)
:    1   2   3   4   5   6   7   8   9   10    :=
1    0   0   0   0   0   0   0   0   0   0
2    0   0   0   0   0   0   0   0   0   0
3    0   0   0   0   0   0   0   0   0   0
4    0   0   0   0   0   0   0   0   0   0
5    0   0   0   0   0   0   0   0   0   0
6    0   0   0   0   0   0   0   0   0   0
7    0   0   0   0   0   0   0   0   0   0
8    0   0   0   0   0   0   0   0   0   0
9    0   0   0   0   0   0   0   0   0   0
10   0   0   0   0   0   0   0   0   0   0
11   0   0   0   0   0   0   0   0   0   0
12   0   0   0   0   0   0   0   0   0   0
13   0   0   0   0   0   0   0   0   0   0
14   0   0   0   0   0   0   0   0   0   0
15   0   0   0   0   0   0   0   0   0   0
16   0   0   0   0   0   0   0   0   0   0
17   0   0   0   0   0   0   0   0   0   0
18   0   0   0   0   0   0   0   0   0   0
19   0   0   0   0   0   0   0   0   0   0
20   0   0   0   0   0   0   0   0   0   0

 [*,*,2] (tr)
:    1   2   3   4   5   6   7   8   9   10    :=
1    1   0   0   1   0   0   0   0   0   0
2    1   0   0   1   0   0   0   0   0   0
3    1   0   0   1   0   0   0   0   0   0
4    1   0   0   1   0   0   0   0   0   0
5    1   0   0   0   0   0   0   0   0   0
6    1   0   0   0   0   0   0   0   0   0
7    1   0   0   0   0   0   0   0   0   0
8    1   0   0   0   0   0   0   0   0   0
9    0   0   0   0   0   0   0   0   0   0
10   0   0   0   0   0   0   0   0   0   0
11   0   0   0   0   0   0   0   0   0   0
12   0   0   0   0   0   0   0   0   0   0
13   0   0   0   0   0   0   0   0   0   0
14   0   0   0   0   0   0   0   0   0   0
15   0   0   0   0   0   0   0   0   0   0
16   0   0   0   0   0   0   0   0   0   0
17   0   0   0   0   0   0   0   0   0   0
18   0   0   0   0   0   0   0   0   0   0
19   0   0   0   0   0   0   0   0   0   0
20   0   0   0   0   0   0   0   0   0   0

 [*,*,3] (tr)
:    1   2   3   4   5   6   7   8   9   10    :=
1    0   0   0   0   0   0   0   0   0   0
2    0   0   0   0   0   0   0   0   0   0
3    0   0   0   0   0   0   0   0   0   0
4    0   0   0   0   0   0   0   0   0   0
5    0   0   0   0   0   0   0   0   0   0
6    0   0   0   0   0   0   0   0   0   0
7    0   0   0   0   0   0   0   0   0   0
8    0   0   0   0   0   0   0   0   0   0
9    0   0   0   0   0   0   0   0   0   0
10   0   0   0   0   0   0   0   0   0   0
11   0   0   0   0   0   0   0   0   0   0
12   0   0   0   0   0   0   0   0   0   0
13   0   0   0   0   0   0   0   0   0   0
14   0   0   0   0   0   0   0   0   0   0
15   0   0   0   0   0   0   0   0   0   0
16   0   0   0   0   0   0   0   0   0   0
17   0   0   0   0   0   0   0   0   0   0
18   0   0   0   0   0   0   0   0   0   0
19   0   0   0   0   0   0   0   0   0   0
20   0   0   0   0   0   0   0   0   0   0
;

