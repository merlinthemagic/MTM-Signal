## Build Signal-Cli with glibc < 2.18 support 

Create Build environment

### Centos 7:

```
yum groupinstall 'Development Tools'
yum install wget zip unzip git-core java-11-openjdk
```

Install Rust:

```
curl --proto '=https' --tlsv1.2 -sSf https://sh.rustup.rs | sh
source $HOME/.cargo/env
```

Build signal:

```
cd /tmp/
git clone https://github.com/AsamK/signal-cli.git
cd signal-cli/

./gradlew build
./gradlew installDist
./gradlew distTar

cp build/distributions/signal-cli-* /tmp/

cd /tmp/
tar -xvf signal-cli-0.9.0.tar


```

Build libsignal_jni.so:

```
cd /tmp/
wget https://github.com/signalapp/libsignal-client/archive/refs/tags/v0.9.6.tar.gz
tar -zxf v0.9.6.tar.gz
cd libsignal-client-0.9.6/java

//Prevent building the android library
sed -i "s/, ':android'//" settings.gradle
./build_jni.sh desktop

cp java/src/main/resources/libsignal_jni.so /tmp/

cd /tmp/
zip -u /tmp/signal-cli-0.9.0/lib/signal-client-java-*.jar libsignal_jni.so

```


Build libzkgroup.so: (0.8.x branch does not work with signal-cli, so get the latest 0.7.x)

```
cd /tmp/
wget -O /tmp/zkgroup-0.7.4.zip https://github.com/signalapp/zkgroup/archive/refs/tags/v0.7.4.zip
unzip zkgroup-0.7.4.zip
cd zkgroup-0.7.4
make libzkgroup

cp target/release/libzkgroup.so /tmp/

cd /tmp/
zip -u /tmp/signal-cli-0.9.0/lib/zkgroup-java-*.jar libzkgroup.so

```

##Content is now useable on centos 7 and 8
/tmp/signal-cli/build/install/signal-cli/



