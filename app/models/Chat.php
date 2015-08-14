<?php

class Chat extends Moloquent
{
	protected $collection = "chats";

	/**
     * Embeds relation with Conversation Collection
     * 
     * @return Array(Conversation)
     */
	public function conversations()
	{
		return $this->embedsMany('Conversation');
	}
}
