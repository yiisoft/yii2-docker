cat <<'MSG'
        _ _  __                                             _
       (_|_)/ _|                                           | |
  _   _ _ _| |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 | | | | | |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 | |_| | | | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
  \__, |_|_|_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
   __/ |
  |___/

MSG

echo "PHP version: ${PHP_VERSION}"

if ! shopt -oq posix; then
  if [ -f /usr/share/bash-completion/bash_completion ]; then
    . /usr/share/bash-completion/bash_completion
  elif [ -f /etc/bash_completion.d/yii ]; then
    . /etc/bash_completion.d/yii
  fi
fi
