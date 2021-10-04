@rem
@rem Copyright 2015 the original author or authors.
@rem
@rem Licensed under the Apache License, Version 2.0 (the "License");
@rem you may not use this file except in compliance with the License.
@rem You may obtain a copy of the License at
@rem
@rem      https://www.apache.org/licenses/LICENSE-2.0
@rem
@rem Unless required by applicable law or agreed to in writing, software
@rem distributed under the License is distributed on an "AS IS" BASIS,
@rem WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
@rem See the License for the specific language governing permissions and
@rem limitations under the License.
@rem

@if "%DEBUG%" == "" @echo off
@rem ##########################################################################
@rem
@rem  signal-cli startup script for Windows
@rem
@rem ##########################################################################

@rem Set local scope for the variables with windows NT shell
if "%OS%"=="Windows_NT" setlocal

set DIRNAME=%~dp0
if "%DIRNAME%" == "" set DIRNAME=.
set APP_BASE_NAME=%~n0
set APP_HOME=%DIRNAME%..

@rem Resolve any "." and ".." in APP_HOME to make it shorter.
for %%i in ("%APP_HOME%") do set APP_HOME=%%~fi

@rem Add default JVM options here. You can also use JAVA_OPTS and SIGNAL_CLI_OPTS to pass JVM options to this script.
set DEFAULT_JVM_OPTS=

@rem Find java.exe
if defined JAVA_HOME goto findJavaFromJavaHome

set JAVA_EXE=java.exe
%JAVA_EXE% -version >NUL 2>&1
if "%ERRORLEVEL%" == "0" goto execute

echo.
echo ERROR: JAVA_HOME is not set and no 'java' command could be found in your PATH.
echo.
echo Please set the JAVA_HOME variable in your environment to match the
echo location of your Java installation.

goto fail

:findJavaFromJavaHome
set JAVA_HOME=%JAVA_HOME:"=%
set JAVA_EXE=%JAVA_HOME%/bin/java.exe

if exist "%JAVA_EXE%" goto execute

echo.
echo ERROR: JAVA_HOME is set to an invalid directory: %JAVA_HOME%
echo.
echo Please set the JAVA_HOME variable in your environment to match the
echo location of your Java installation.

goto fail

:execute
@rem Setup the command line

set CLASSPATH=%APP_HOME%\lib\signal-cli-0.9.0.jar;%APP_HOME%\lib\junit-platform-native-0.9.5.jar;%APP_HOME%\lib\lib.jar;%APP_HOME%\lib\bcprov-jdk15on-1.69.jar;%APP_HOME%\lib\argparse4j-0.9.0.jar;%APP_HOME%\lib\dbus-java-3.3.0.jar;%APP_HOME%\lib\slf4j-simple-1.7.30.jar;%APP_HOME%\lib\junit-platform-console-1.7.2.jar;%APP_HOME%\lib\junit-platform-reporting-1.7.2.jar;%APP_HOME%\lib\junit-platform-launcher-1.7.2.jar;%APP_HOME%\lib\junit-jupiter-5.7.2.jar;%APP_HOME%\lib\junit-jupiter-engine-5.7.2.jar;%APP_HOME%\lib\junit-platform-engine-1.7.2.jar;%APP_HOME%\lib\junit-jupiter-params-5.7.2.jar;%APP_HOME%\lib\junit-jupiter-api-5.7.2.jar;%APP_HOME%\lib\junit-platform-commons-1.7.2.jar;%APP_HOME%\lib\jnr-unixsocket-0.38.5.jar;%APP_HOME%\lib\slf4j-api-1.7.30.jar;%APP_HOME%\lib\signal-service-java-2.15.3_unofficial_28.jar;%APP_HOME%\lib\protobuf-javalite-3.10.0.jar;%APP_HOME%\lib\apiguardian-api-1.1.0.jar;%APP_HOME%\lib\jnr-enxio-0.32.3.jar;%APP_HOME%\lib\jnr-posix-3.1.4.jar;%APP_HOME%\lib\jnr-ffi-2.2.1.jar;%APP_HOME%\lib\jnr-constants-0.10.1.jar;%APP_HOME%\lib\threetenbp-1.3.6.jar;%APP_HOME%\lib\libphonenumber-8.12.17.jar;%APP_HOME%\lib\jackson-databind-2.9.9.2.jar;%APP_HOME%\lib\signal-client-java-0.9.5.jar;%APP_HOME%\lib\okhttp-4.6.0.jar;%APP_HOME%\lib\rxjava-3.0.13.jar;%APP_HOME%\lib\zkgroup-java-0.7.0.jar;%APP_HOME%\lib\opentest4j-1.2.0.jar;%APP_HOME%\lib\jffi-1.3.1.jar;%APP_HOME%\lib\jffi-1.3.1-native.jar;%APP_HOME%\lib\asm-commons-9.0.jar;%APP_HOME%\lib\asm-util-9.0.jar;%APP_HOME%\lib\asm-analysis-9.0.jar;%APP_HOME%\lib\asm-tree-9.0.jar;%APP_HOME%\lib\asm-9.0.jar;%APP_HOME%\lib\jnr-a64asm-1.0.0.jar;%APP_HOME%\lib\jnr-x86asm-1.0.2.jar;%APP_HOME%\lib\jackson-annotations-2.9.0.jar;%APP_HOME%\lib\jackson-core-2.9.9.jar;%APP_HOME%\lib\okio-jvm-2.6.0.jar;%APP_HOME%\lib\kotlin-stdlib-1.3.71.jar;%APP_HOME%\lib\reactive-streams-1.0.3.jar;%APP_HOME%\lib\kotlin-stdlib-common-1.3.71.jar;%APP_HOME%\lib\annotations-13.0.jar


@rem Execute signal-cli
"%JAVA_EXE%" %DEFAULT_JVM_OPTS% %JAVA_OPTS% %SIGNAL_CLI_OPTS%  -classpath "%CLASSPATH%" org.asamk.signal.Main %*

:end
@rem End local scope for the variables with windows NT shell
if "%ERRORLEVEL%"=="0" goto mainEnd

:fail
rem Set variable SIGNAL_CLI_EXIT_CONSOLE if you need the _script_ return code instead of
rem the _cmd.exe /c_ return code!
if  not "" == "%SIGNAL_CLI_EXIT_CONSOLE%" exit 1
exit /b 1

:mainEnd
if "%OS%"=="Windows_NT" endlocal

:omega
