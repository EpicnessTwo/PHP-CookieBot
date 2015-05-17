<?php
class Phergie_Plugin_CB_Toggle extends Phergie_Plugin_Abstract
{
    public function onLoad()
    {
        $this->getPluginHandler()->getPlugin('Command');
		$this->getPluginHandler()->getPlugin('Send');
		$this->getPluginHandler()->getPlugin('Permission');
		$this->getPluginHandler()->getPlugin('UserInfo');
    }
    
    public function validCommand($plugin = null)
    {
        $commands = array(
                    "Bunny",
                    "Cookie",
                    "Say",
                );
                
        if ($plugin === null)
        {
        	return $commands;
        } else {
        	if (in_array($plugin, $commands))
        	{
        	    return true;
        	} else {
        	    return false;
        	}
        }
    }
    
    public function onCommandToggle($plugin, $toggle = null)
    {
        $event = $this->getEvent();
		$source = $event->getSource();
		$nick = $event->getNick();
		$hostmask = explode("!", $this->event->getHostmask());
		$hostmask = $hostmask[1];
		$plugin = ucwords(strtolower($plugin));
		
		if ($this->plugins->permission->getLevel($hostmask) >= 3)
    	{
	    	if ($plugin == "List")
	    	{
	    		$commands = $this->validCommand();
	    		
	    		foreach ($commands as $command)
	    		{
	    			$c = "CB_" . $command;
	    			$out[$command] = $command . " = " . $this->plugins->$c->getToggle() . "\x0F";
	    		}
	    		
	    		$this->plugins->send->send($source, implode(" - ", $out), $nick);
	    	}
	    	else if ($this->validCommand($plugin))
	    	{
	    	
	    	    if ($toggle === null)
	    	    {
	    	        $plugin = "CB_" . $plugin;
	    	        $this->plugins->$plugin->setToggle();
	    	        $this->plugins->send->send($source, "$plugin toggle is now " . $this->plugins->$plugin->getToggle(), $nick);
	    	    } else {
	    	        $plugin = "CB_" . $plugin;
	    	        $this->plugins->$plugin->setToggle($toggle);
	    	        $this->plugins->send->send($source, "$plugin toggle is now " . $this->plugins->$plugin->getToggle(), $nick); 
	    	    }
	    	} else {
	    	    $this->plugins->send->send($source, "The plugin $plugin doesn't seam to be valid", $nick);
	    	}
    	} else {
    	    $this->plugins->send->send($source, $this->getConfig('error.noperms') , $nick);
    	}
    }
}