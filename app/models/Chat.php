<?php

class Chat extends Moloquent
{
	protected $collection = "chats";

	public function conversations()
	{
		return $this->embedsMany('Conversation');
	}
}
