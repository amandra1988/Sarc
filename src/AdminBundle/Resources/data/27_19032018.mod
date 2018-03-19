# Modelo de asignacion y programacion de clientes 

# Paramentros

param m > 0;   #cantidad de dias
param n > 0;   #cantidad de vehiculos
param p >=0;   #infinito
param e >=0;   # variable epsilon
param e2 >=0;   # variable epsilon
 
# Conjuntos

#conjuntos de clientes
set diario;
set trisemanal;
set disemanal;
set semanal;  
set quincenal;
set mensual;
set clientes := diario union trisemanal union disemanal union semanal union quincenal union mensual;
set dias := 1..m;
#conjunto cluster
set vehiculos:= 1..n;

# Parametros ingreso modelo
 
param demanda {clientes} > 0;     #demanda asociada a cada cliente 
param frecuencia {clientes} > 0;  #frecuencia asociada a cada cliente 
param capacidad {vehiculos} > 0;  #capacidad de cada camion
param theta {clientes} > 0;       #angulo asociado a cada cliente respecto al deposito(planta)

# Varibles de decision 

#asignacion de clientes
var x {i in clientes, j in dias} >= 0, binary;
var cap {j in dias} >= 0;   # capacidad diaria 
var capmax >= 0;            # capacidad maxima del dia (balancea las cargas) 

#cluster de clientes 
var y {i in clientes,j in dias, k in vehiculos} >=0, binary;
var thetam {j in dias, k in vehiculos} >=0;
var thetap {j in dias, k in vehiculos} >=0;
var thetad {j in dias, k in vehiculos} >=0;
var theta2 {j in dias, k in vehiculos} >=0;

# Funcion objetivo
minimize fobj: capmax;

# Restricciones 

#limita la jornada laboral a 25 clientes diarios
#subject to rjl {j in dias, k in vehiculos}: sum {i in clientes} y[i,j,k] <= 25;

#asignacion de clientes
#asigna a todos los clientes (mensuales y diarios)
subject to rfreq {i in clientes}: sum{j in dias} x[i,j] = frecuencia[i];
# clientes quincenales
subject to rqui {i in quincenal,j in {1..10}}: x[i,j] = x[i,j+10];
# clientes semanales
subject to rsem2 {i in semanal,j in {1..5}}: x[i,j] = x[i,j+5];
subject to rsem3 {i in semanal,j in {1..5}}: x[i,j] = x[i,j+10];
subject to rsem4 {i in semanal,j in {1..5}}: x[i,j] = x[i,j+15];
# clientes disemanales
subject to rdis11 {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+2];
subject to rdis2a {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+5];
subject to rdis2b {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+7];
subject to rdis3a {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+10];
subject to rdis3b {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+12];
subject to rdis4a {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+15];
subject to rdis4b {i in disemanal,j in {1..2}}: x[i,j] = x[i,j+17];
subject to rdisvi {i in disemanal,j in {5,10,15,20}}: x[i,j] = 0;
#clientes trisemanales
subject to rtri {i in trisemanal,j in {2,4,7,9,12,17,19}}: x[i,j] = 0;
#definicion de la capacidad
subject to rdemcap {j in dias}:sum {i in clientes} x[i,j] * demanda[i] = cap[j];
subject to rdemmax {j in dias}: cap[j] <= capmax;

#cluster de clientes
#cada cliente perteneces solo a un cluster 
subject to rpc {i in clientes, j in dias}: x[i,j]= sum {k in vehiculos} y[i,j,k];
#capacidad de los vehiculos con respecto a las demandas de los clientes 
subject to cpc {j in dias, k in vehiculos}: sum {i in clientes} demanda[i] * y[i,j,k] <= capacidad[k];
#creacion de los cluster 
subject to rth1 {i in clientes, j in dias, k in vehiculos}: theta[i]>= thetam[j,k] + (1-y[i,j,k]) * -p;
subject to rth2 {i in clientes, j in dias, k in vehiculos}: theta[i]<= thetap[j,k] + (1-y[i,j,k]) * p;

# restricciones de epsilon theta
subject to ep1 {j in dias, k in vehiculos}: thetap[j,k] - thetam[j,k] = thetad[j,k];
subject to ep2 {j in dias, k in vehiculos}: thetad[j,k] <= e;

# restricciones de epsilon ncus
subject to rt3 {j in dias, k in vehiculos}: sum {i in clientes} y[i,j,k] = theta2[j,k];
subject to rt4 {j in dias, k in vehiculos}: theta2[j,k] <= e2;