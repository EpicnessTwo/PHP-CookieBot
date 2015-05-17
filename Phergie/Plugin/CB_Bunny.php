<?php
class Phergie_Plugin_CB_Bunny extends Phergie_Plugin_Abstract
{
    private static $toggle;
    public function onLoad()
    {
        $this->getPluginHandler()->getPlugin('Command');
		$this->getPluginHandler()->getPlugin('Send');
		$this->getPluginHandler()->getPlugin('Permission');
		$this->getPluginHandler()->getPlugin('UserInfo');
		self::$toggle = true;
    }
    
    public function getToggle()
    {
        if (self::$toggle)
        {
            return "\x02\x0303on";
        } else {
            return "\x02\x0304off";
        }
    }
    
    public function setToggle($state = null)
    {
        if ($state === null)
        {
            self::$toggle = !self::$toggle;
        } else {
            if ($state = ("true" | "on" | "1"))
            {
                self::$toggle = true;
            }
            else if ($state = ("false" | "off" | "0"))
            {
                self::$toggle = false;
            }
            
        }
    }
    public function onCommandBunny()
    {
        $event = $this->getEvent();
		$source = $event->getSource();
		$nick = $event->getNick();
		$hostmask = explode("!", $this->event->getHostmask());
		$hostmask = $hostmask[1];
		
		if ($this->getToggle() == "\x02\x0303on")
		{
            $faces = array(
                    "O_o",
                    "+_+",
                    "@~@",
                    "*^*",
                    "o.o",
                    "^v^",
                    "$-$",
                    "'~'",
                    "0w0",
                    "-_-",
                    "'-'",
                    "~_~",
                    "+=+",
                    "^_^",
                    ",^,"
                );
                
            if (rand(1,2) == 1)
            {
                $this->plugins->send->send($source, "(\\__/)", $nick);
                $this->plugins->send->send($source, "( " . $faces[rand(0, count($faces) - 1)] . ")", $nick);
                $this->plugins->send->send($source, "(\")(\")", $nick);
            } else {
                $this->plugins->send->send($source, "(\\__/)", $nick);
                $this->plugins->send->send($source, "( " . $faces[rand(0, count($faces) - 1)] . ")/)", $nick);
                $this->plugins->send->send($source, "(\")(\")", $nick);
            }
            
            
            
		} else {
		    $this->doNotice($nick, "This plugin is disabled!");
		}
    }
}