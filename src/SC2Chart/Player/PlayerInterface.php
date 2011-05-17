<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart\Player;

interface PlayerInterface
{
	function getName();
	function getActions();
	function getMaxApm();
	function getColor();
	function getRace();
	function getTeam();
	function isObs();
	function isWinner();
	function addPlot($x, $y);
	function getPlots();
}