<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart\Replay;

interface ReplayInterface
{
	function getCTime();
	function getPlayers();
	function getMap();
	function getLength();
	function getRealm();
	function getVersion();
	function getBuild();
	function getChatLog();
}