<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart\Charter;

use SC2Chart\SC2Chart;
use SC2Chart\Replay\ReplayInterface;

/**
 * Charter Interface
 * Implement this class in order to populate a Replay Interface into a cute and funky chart.
 *
 * @version	0.1
 * @author	Antoine Berranger <antoine@ihqs.net>
 */
interface CharterInterface
{
	/**
	 * Implement this method to transform a ReplayInterface into a chart.
	 *
	 * @param   ReplayInterface     $replay     The Replay object to process
	 * @param   string              $filename   The name of the image chart to create
	 * @param   SC2Chart            $sc2chart   The core object, here to access configuration variables
	 */
	function create(ReplayInterface $replay, $filename, SC2Chart $sc2chart);
}