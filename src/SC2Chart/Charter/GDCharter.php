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

class GDCharter implements CharterInterface
{
	protected $sc2chart;
	protected $replay;
	protected $filename;

	protected $width;
	protected $height;
	protected $precision;

	protected $imgh;
	protected $colors = array();
	
	public function create(ReplayInterface $replay, $filename, SC2Chart $sc2chart)
	{
		$this->replay = $replay;
		$this->filename = $filename;
		$this->sc2chart = $sc2chart;

		$this->max_apm = 0;
		foreach($this->replay->getPlayers() as $player)
		{
			if($this->max_apm < $player->getMaxApm())
			{
				$this->max_apm = $player->getMaxApm();
			}
		}

		$this->width		= $this->sc2chart->getChartWidth();
		$this->height		= $this->sc2chart->getChartHeight();
		$this->precision	= $this->sc2chart->getChartPrecision();

		$this->createFrame();
		$this->drawPlots();
		$this->populate();
	}

	public function createFrame()
	{
		// creating image
		$this->imgh = imagecreatetruecolor($this->width, $this->height);

		// allocating colors
		$this->colors['black'] = imagecolorallocate($this->imgh, 000, 000, 000);
		$this->colors['gray']  = imagecolorallocate($this->imgh, 192, 192, 192);
		$this->colors['white'] = imagecolorallocate($this->imgh, 255, 255, 255);
		$this->colors['white_a'] = imagecolorallocatealpha($this->imgh, 255, 255, 255, 127);

		imagefill($this->imgh, 0, 0, $this->colors['white_a']);

		foreach($this->replay->getPlayers() as $player)
		{
			$color = $player->getColor();
			$r = hexdec(substr($color, 0, 2));
			$g = hexdec(substr($color, 2, 2));
			$b = hexdec(substr($color, 4, 2));

			$this->colors[$player->getName().'_fg'] = imagecolorallocate($this->imgh, $r, $g, $b);
			$this->colors[$player->getName().'_bg'] = imagecolorallocatealpha($this->imgh, $r, $g, $b, 110);
		}
	}

	public function drawPlots()
	{
		foreach($this->replay->getPlayers() as $player)
		{
			$plots = $player->getPlots();
			
			foreach(range($this->precision + 1, $this->width, $this->precision) as $i)
			{
				if(!isset($plots[$i  - $this->precision]))
				{
					continue;
				}

				imagesetthickness($this->imgh, 1);
				imagefilledpolygon(
					$this->imgh,
					array(
						$i - $this->precision + 1, $this->height,
						$i - $this->precision + 1, $this->height - $plots[$i  - $this->precision],
						$i, $this->height - $plots[$i] / $this->max_apm * $this->height,
						$i, $this->height ,
					),
					4,
					$this->colors[$player->getName().'_bg']
				);

				imagesetthickness($this->imgh, 3);
				imageline(
					$this->imgh,
					$i - $this->precision + 1,
					$this->height - $plots[$i - $this->precision] / $this->max_apm * $this->height,
					$i,
					$this->height - $plots[$i] / $this->max_apm * $this->height,
					$this->colors[$player->getName().'_fg']
				);
			}
		}
	}

	public function populate()
	{
		// drawing graphic's frame
		$frame = imagecreatetruecolor($this->width + 39, $this->height + 20);

		// global frame
		imagefill($frame, 0, 0, $this->colors['white']);
		imagerectangle($frame, 25, 0, $this->width + 25, $this->height, $this->colors['gray']);
		imageline($frame, 25, $this->height / 2, $this->width + 25, $this->height / 2, $this->colors['gray']);

		// data values
		$this->imagewrite($frame, 10, 8, $this->height - 0, "0", $this->colors['black']);
		$this->imagewrite($frame, 10, 0, ($this->height / 2) + 5, floor($this->max_apm / 2), $this->colors['black']);
		$this->imagewrite($frame, 10, 0, 10, floor($this->max_apm), $this->colors['black']);

		$length_minutes = ($this->replay->getLength() / 60);
		for ($i = 0; $i < $length_minutes; $i+=5)
		{
			$this->imagewrite($frame, 10, 25 + ($this->width / ($length_minutes / 5) * ($i / 5)), $this->height + 12, $i . " min", $this->colors['black']);
			if ($i > 0)
			{
				imageline(
					$frame,
					25 + ($this->width / ($length_minutes / 5) * ($i / 5)),
					0,
					25 + ($this->width / ($length_minutes / 5) * ($i / 5)),
					$this->height,
					$this->colors['gray']
				);
			}
		}

		// copy the graph onto the container image and save it
		imagecopy($frame, $this->imgh, 25, 0, 0, 0, $this->width, $this->height);
		imagepng($frame, $this->filename);
		imagedestroy($frame);
		imagedestroy($this->imgh);
	}

	protected function imagewrite($imgh, $size, $width, $height, $text, $color, $bold = false)
	{
		if(!function_exists("imagettftext"))
		{
			$size = floor($size / 4);
			imagestring($imgh, $size, $width, $height, $text, $color);
		}

		else
		{
			$font  = $this->sc2chart->locateFont('Georgia', $bold);
			$angle = 0;
			imagettftext($imgh, $size, $angle, $width, $height, $color, $font, $text);
		}
	}
}