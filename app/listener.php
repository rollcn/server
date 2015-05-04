<?php

Event::listen('illuminate.query',function($sql,$param)
{
	Log::info($sql . ",with[" . join('.',$param)."]");
});