#! /bin/bash

# ECHO COMMAND
echo Hello World!

# VARIABLES
# Uppercase by convention, with letters, numbers, underscores
NAME="Aurel"
echo "My name is $NAME"
echo "My name is ${NAME}"

# USER INPUT
read -p "Enter your name: " NAME
echo "Hello $NAME!"

# SIMPLE IF STATEMENT
if [ "$NAME" == "Aurel" ]
then
  echo "Your name is Aurel."
fi

# IF STATEMENT
if [ "$NAME" == "Aurel" ]
then
  echo "Your name is Aurel."
else
  echo "Your name is not Aurel."
fi

# ELSE-IF (elif)
if [ "$NAME" == "Aurel" ]
then
  echo "Your name is Aurel."
elif [ "$name" == "Colin" ]
  echo "Your name is not Colin."
else
  echo "Your name is not Aurel or Colin."
fi

# COMPARISON
# VAL1 -eq VAL2  --- equal
# VAL1 -ne VAL2  --- not equal
# VAL1 -gt VAL2  --- greater than
# VAL1 -ge VAL2  --- greater than or equal
# VAL1 -lt VAL2  --- lower than
# VAL1 -le VAL2  --- lower than or equal

