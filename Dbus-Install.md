# Signal-Cli Dbus install

## Add service user

Setup a new user the DBUS service can run as. 


NOTE: If you change the username and you have to change the config files as well

```
useradd signalUsr
usermod -L signalUsr
```

## Data store

Create a directory that will house the data.

NOTE: if you change this config file have to change as well

```
mkdir -p /var/lib/signal-cli
chown -R signalUsr /var/lib/signal-cli/
```

## Copy config files


ACTON: change the ExecStart path in the signal-cli.service file to reflect your binary path before copying the file

```
cd /path/to/Mtm-Signal-Api/Vendors/SignalCli/dbus
cp ./org.asamk.Signal.conf /etc/dbus-1/system.d/
cp ./org.asamk.Signal.service /usr/share/dbus-1/system-services/

//CHANGE this file!
cp ./signal-cli.service /etc/systemd/system/
```

## Run the service

```
systemctl daemon-reload
systemctl enable signal-cli.service
systemctl reload dbus.service
```

### Service should show as dead

```
systemctl status signal-cli.service
```


### Start the process

dbus is not going to kick off until someone talks to it

```
dbus-send --system --print-reply --type=method_call --dest="org.asamk.Signal" /org/asamk/Signal org.asamk.Signal.sendMessage string:"Hello World" array:string: string:+13103456789
```


### Service should show Active

```
systemctl status signal-cli.service
```

## Receive messages

ACTON: change the to reflect your binary path before executing

```
/path/to/Mtm-Signal-Api/Vendors/SignalCli/bin/signal-cli --dbus-system --config "/var/lib/signal-cli/" -o json -u '+12134562345' receive
```


##Troubleshooting

Random notes

```
dbus-send --system --print-reply --dest="org.freedesktop.DBus" /org/freedesktop/DBus org.freedesktop.DBus.ListActivatableNames

systemctl status dbus.service
```