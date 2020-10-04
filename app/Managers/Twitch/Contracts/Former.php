<?php

namespace App\Managers\Twitch\Contracts;

interface Former
{
	public function clips(array $clips);
	public function clip(array $clips);
}
