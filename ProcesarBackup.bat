echo of
set FECHA= %date%
set FECHA=%FECHA:/=%
set FECHA=%FECHA: =%
set FECHA=%FECHA::=%
set FECHA=%FECHA:,=%
set hora=%TIME:~,2%
set min=%TIME:~3,2%
set backupSql=appacademy_%fecha%_%min%.sql
d:
cd D:\xampp\mysql\bin                                  
mysqldump -u backup --password=1234 appacademy > D:\wamp\www\appacademyMisonal\backupSQL\%backupSql%
