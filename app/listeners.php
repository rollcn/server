<?php

DB::listen(function($sql,$bindings,$time)
{
	Log::info('[SQL]'.$sql."with:".join(',',$bindings));
});