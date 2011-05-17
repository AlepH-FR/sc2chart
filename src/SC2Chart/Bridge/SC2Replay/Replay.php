<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart\Bridge\SC2Replay;

use SC2Chart\Replay\ReplayInterface;

class Replay extends \SC2Replay implements ReplayInterface
{
	private $playersInit = false;
	protected $playersProcessed;

	public function getCTime()
	{
		return new \DateTime(date('Y-m-d H:i:s', parent::getCtime()));
	}

	public function getPlayers()
	{
		if(!$this->playersInit)
		{
			$this->initPlayers();
		}

		return $this->playersProcessed;
	}

	public function getMessages()
	{
		$messages = parent::getMessages();
		$players  = parent::getPlayers();

		foreach($players as $key => $data)
		{
			$color = isset($data['color']) ? $data['color'] : '888888';
			$colors[$data['name']] = $color;
		}

		foreach($messages as $key => $message)
		{
			$messages[$key]['color'] = $colors[$message['name']];
		}

		return $messages;
	}

	public function getMap()
	{
		return $this->getMapName();
	}

	public function getLength()
	{
		return $this->getGameLength();
	}

	public function getChatLog()
	{
		return $this->getMessages();
	}

	private function initPlayers()
	{
		foreach(parent::getPlayers() as $player)
		{
			$processedPlayer = new Player();
			if($player['team'] != 0)
			{
				$processedPlayer
					->setName($player['name'])
					->setColor($player['color'])
					->setActions($player['apm'])
					->setRace($player['race'])
					->setTeam($player['team'])
					->setObs(false)
                                ;

                                if(isset($player['won']))
                                {
                                    $processedPlayer->setWinner($player['won']);
                                }
			}
			else
			{
				$processedPlayer
					->setName($player['name'])
					->setObs(true)
				;
			}

			$this->playersProcessed[] = $processedPlayer;
		}

		$this->playersInit = true;
	}
}