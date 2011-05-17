<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart\Analyzer;

use SC2Chart\SC2Chart;
use SC2Chart\Replay\ReplayInterface;
use SC2Chart\Player\PlayerInterface;

/**
 * Analyzer Interface
 * Implement this class in order to create your own analyzers based on the libraries you want to use. Or just create an SC2Replay file reader in it !
 * 
 * @version	0.1
 * @author	Antoine Berranger <antoine@ihqs.net>
 */
interface AnalyzerInterface
{
	/**
	 * Implement this core method. Basically it must launch the buildReplay method and use properly the parseReplay and parsePlayer methods.
	 * It must return a ReplayInterface instance
	 *
	 * @param   string              $replayFile     Path to the source replay file
	 * @param	SC2Chart			$sc2chart		The core object, here to access configuration variables
	 * @return  ReplayInterface     $replay
	 */
	function process($replayFile, SC2Chart $sc2chart);

	/**
	 * Implement this method to transform a replay file to an object
	 * This object must be an instance of a class implementing SC2Chart\Replay\ReplayInterface
	 * It must return a ReplayInterface instance
	 *
	 * @param   string              $replayFile     Path to the source replay file
	 * @return  ReplayInterface     $replay
	 */
	function buildReplay($replayFile);

	/**
	 * Parse a Replay to extract useful informations
	 *
	 * @param   ReplayInterface     $replay     The replay object to parse
	 */
	function parseReplay(ReplayInterface $replay);

	/**
	 * Parse a Player to extract useful informations
	 *
	 * @param   PlayerInterface     $player     The player object to parse
	 */
	function parsePlayer(PlayerInterface $player);
}