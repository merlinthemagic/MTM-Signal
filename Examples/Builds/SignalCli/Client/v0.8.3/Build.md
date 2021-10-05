##Build Signal-Cli with glibc < 2.18 support 

yum groupinstall 'Development Tools'
yum install wget zip unzip git-core java-11-openjdk


curl --proto '=https' --tlsv1.2 -sSf https://sh.rustup.rs | sh
##option 1

source $HOME/.cargo/env

wget -O /tmp/gradle.zip  https://services.gradle.org/distributions/gradle-6.7.1-bin.zip
mkdir /opt/gradle
unzip -d /opt/gradle /tmp/gradle.zip
export PATH=$PATH:/opt/gradle/gradle-6.7.1/bin

cd /tmp/
wget -O /tmp/libsignal-client-0.6.0.zip https://github.com/signalapp/libsignal-client/archive/refs/tags/v0.6.0.zip

unzip libsignal-client-0.6.0.zip
cd libsignal-client-0.6.0/java
sed -i "s/, ':android'//" settings.gradle
chmod +x build_jni.sh
./build_jni.sh desktop

cd /tmp/
wget -O /tmp/zkgroup-0.7.1.zip https://github.com/signalapp/zkgroup/archive/v0.7.1.zip
unzip zkgroup-0.7.1.zip
cd zkgroup-0.7.1
make libzkgroup

cd /tmp/
git clone https://github.com/AsamK/signal-cli.git
cd ./signal-cli
gradle build
gradle installDist
gradle distTar

cd /tmp/zkgroup-0.7.1/target/release/
zip -u /tmp/signal-cli/build/install/signal-cli/lib/zkgroup-java-0.7.0.jar libzkgroup.so

cd /tmp/libsignal-client-0.6.0/target/release
zip -u /tmp/signal-cli/build/install/signal-cli/lib/signal-client-java-0.5.1.jar libsignal_jni.so

##Content is now useable on centos 7 and 8
/tmp/signal-cli/build/install/signal-cli/



