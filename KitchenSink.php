<?php
App::uses('AppModel', 'Model');

/**
 * KitchenSink Model
 * 
 * Allow you to quickly save away a value globally available for any time. (apart from Session, which works great for any Session-data.)
 * The value is a VARCHAR stored through php's serialize() function. 
 * 
 * The key value is case sensitive, "skåne" is not the same as "Skåne". 
 * All values are stored in the utf8_unicode_ci collation, so pretty much any character should pass.
 * 
 */
class KitchenSink extends AppModel 
{
	public $useTable = 'kitchen_sink'; // It sounds so bad with cakes default 'kitchen_sinks'. :)
	
	public function Store($key, $value)
	{
		$serialized = serialize($value);
		
		$obj = $this->find('first', array(
			'conditions' => array(
				'key' => $key
			),
			'fields' => array('id')
		));
		// debug($obj);
		
		if(count($obj) > 0)
		{
			// It's here already, update.
			$this->read(null, $obj['KitchenSink']['id']);
		}
		else
		{
			// New.
			$this->set('key', $key);
		}
		
		$this->set('value', $serialized);
		$this->save();
	}
	
	public function Retrieve($key)
	{
		$obj = $this->find('first', array(
			'conditions' => array(
				'key' => $key
			),
			'fields' => array('value')
		));
		// debug($obj);
		
		if(count($obj) == 0)
			return null;
		
		return unserialize($obj['KitchenSink']['value']);
	}
	
	public function Forget($key)
	{
		$conditions = array(
			'key' => $key
		);
		
		$this->deleteAll($conditions);
	}
}

/* 

CREATE TABLE `kitchen_sink` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`key` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`value` VARCHAR(4096) NOT NULL COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`id`),
	UNIQUE `u_key` (`key`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

*/

/*

	// Small test-code.
	$this->loadModel('KitchenSink');
	$this->KitchenSink->Store("flowers",array('flowers' => 'sweet', 'antal' => 12));
	$val = $this->KitchenSink->Retrieve("flowers");
	debug($val); // The array of valuable flowers-data.
	
	$this->KitchenSink->Forget("flowers");
	
	$val = $this->KitchenSink->Retrieve("flowers");
	debug($val); // null, does no longer exist
	
	// Really, who stores anything in a kitchen sink anyway? And where is the joke?!
	$this->KitchenSink->Store("Monkeys", array("Messy things in trees."));
	$this->KitchenSink->Store("Monkeys", array("Monkeys in the djungle."));

*/

