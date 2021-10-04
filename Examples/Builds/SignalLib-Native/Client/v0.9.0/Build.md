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
```

Setup components:

```
source $HOME/.cargo/env

wget -O /tmp/gradle.zip  https://services.gradle.org/distributions/gradle-7.2-bin.zip
mkdir /opt/gradle
unzip -d /opt/gradle /tmp/gradle.zip
export PATH=$PATH:/opt/gradle/gradle-7.2/bin

cd /tmp/
wget -O /tmp/libsignal-client-0.9.6.zip https://github.com/signalapp/libsignal-client/archive/refs/tags/v0.9.6.zip

unzip libsignal-client-0.9.6.zip
cd libsignal-client-0.9.6/java
sed -i "s/, ':android'//" settings.gradle
chmod +x build_jni.sh
./build_jni.sh desktop

cd /tmp/
wget -O /tmp/zkgroup-0.8.2.zip https://github.com/signalapp/zkgroup/archive/refs/tags/v0.8.2.zip
unzip zkgroup-0.8.2.zip
cd zkgroup-0.8.2
make libzkgroup

cd /tmp/
git clone https://github.com/AsamK/signal-cli.git
cd ./signal-cli
gradle build
gradle installDist
gradle distTar

cd /tmp/zkgroup-0.8.2/target/release/
zip -u /tmp/signal-cli/build/install/signal-cli/lib/zkgroup-java-0.7.0.jar libzkgroup.so

cd /tmp/libsignal-client-0.9.6/target/release
zip -u /tmp/signal-cli/build/install/signal-cli/lib/signal-client-java-0.9.5.jar libsignal_jni.so

```

##Content is now useable on centos 7 and 8
/tmp/signal-cli/build/install/signal-cli/



