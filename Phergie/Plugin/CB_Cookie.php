<?php
class Phergie_Plugin_CB_Cookie extends Phergie_Plugin_Abstract
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
    public function onCommandCookie($user = null)
    {
        $event = $this->getEvent();
		$source = $event->getSource();
		$nick = $event->getNick();
		$hostmask = explode("!", $this->event->getHostmask());
		$hostmask = $hostmask[1];
		
		if ($this->getToggle() == "\x02\x0303on")
		{
            $cookies = array(
                    "\x033R\x032a\x033i\x034n\x035b\x036o\x037w \x038C\x039o\x0310o\x037k\x032i\x033e\x034s\x0F",
                    "Chocolate Chip Cookies",
                    "Loads of Cookies",
                    "a Special Cookie",
                    "a Magical Cookie",
                    "one of Annabell's Cookies",
                    "some Cookies",
                    "some bread",
                    "a Giant Cookie",
                    "part of itself"
                );
            
            if ($user === null)
            {
                $user = $nick;
            }
            
            $this->doAction($source, "gives " . $cookies[rand(0, count($cookies) - 1)] . " to " . $user);
		} else {
		    $this->doNotice($nick, "This plugin is disabled!");
		}
    }
}