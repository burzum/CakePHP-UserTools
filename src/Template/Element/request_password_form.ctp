<?php
echo $this->Form->create('User');
echo $this->Form->input('email', array(
	'label' => __d('user_tools', 'Email'),
	'required' => false,
));
echo $this->Form->submit(__d('user_tools', 'Login'));
echo $this->Form->end();