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

use SC2Chart\Analyzer\AbstractAnalyzer;
use SC2Chart\Analyzer\AnalyzerInterface;

class Analyzer extends AbstractAnalyzer implements AnalyzerInterface
{
	/**
	 * @param   string              $replayFile     Path to the source replay file
	 * @return  ReplayInterface     $replay
	 */
	public function buildReplay($replayFile)
	{
		if(!class_exists("\MPQFile"))
		{
			throw new \RuntimeException('Please require the SC2Replay MPQFile class');
		}

		$mpq = new \MPQFile($replayFile);
		
		$sc2replay = new Replay();
		$sc2replay->parseReplay($mpq);
		return $sc2replay;
	}
}