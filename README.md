# kitchen_sink
Allow you to quickly save and retrieve any type of value in a kitchen_sink mysql table.

The KitchenSink.php is adapted for Cake PHP 2, while the KitchenSinkTable.php is adapted for Cake 3. 

This is a 'everything and the kitchen sink' table, where you can store any type of value through Store(). You give your data a key, a unique name, to identify it. 

It uses php's serialize() to convert any (well, I guess most) type of php data type and arrays into a serialized string. 

Get your data back with a call to Retrieve(). 

Delete your data with Forget(). 

You can find a real usage example in this project: https://github.com/Snorvarg/simplicity

Examples for Cake 2: (Also found in source file)

	// Store an array of data about flowers.
	$this->loadModel('KitchenSink');
	$this->KitchenSink->Store("flowers",array('flowers' => 'sweet', 'numbers_in_a_set' => 12));
  
	// Refetch the data from database. 
	$val = $this->KitchenSink->Retrieve("flowers");
	debug($val); // The array of valuable flowers-data.
	
	// Remove from database.
	$this->KitchenSink->Forget("flowers");
	
	// Now this will give null.
	$val = $this->KitchenSink->Retrieve("flowers");
	debug($val); // null, does no longer exist
	
	// Several calls to Store() with same key will overwrite old value.
	$this->KitchenSink->Store("Monkeys", array("Messy things in trees."));
	$this->KitchenSink->Store("Monkeys", array("Monkeys in the djungle."));
