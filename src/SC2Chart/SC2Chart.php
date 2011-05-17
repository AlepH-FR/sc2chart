<?php
/*
 * This file is part of the SC2Chart package.
 *
 * (c) Antoine Berranger <antoine@ihqs.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SC2Chart;

use SC2Chart\Analyzer\AnalyzerInterface;
use SC2Chart\Charter\CharterInterface;

class SC2Chart
{
	protected $file;
	protected $analyzer;
	protected $charter;

	protected $chartWidth		= 481;
	protected $chartHeight		= 160;
	protected $chartPrecision	= 5;

	public function __construct(AnalyzerInterface $analyzer, CharterInterface $charter)
	{
		$this->analyzer = $analyzer;
		$this->charter	= $charter;
	}

	public function populate($src_file, $dest_filename = '')
	{
		$this->file	= $src_file;

		$this->replay = $this->analyzer->process($this->file, $this);
		$this->charter->create($this->replay, $dest_filename, $this);
	}

	public function locateFont($name, $bold = false)
	{
		$base = dirname(__FILE__) . '/Resources/fonts';
		$file = strtoupper($name) . ($bold ? 'B' : '') . '.TTF';

		$file_path = $base . '/' . $file;
		if(!file_exists($file_path))
		{
			throw new \RuntimeException('Impossible to locate font file "' . $file . '"');
		}

		return $file_path;
	}

	public function setAnalyzer(AnalyzerInterface $analyzer)
	{
		$this->analyzer = $analyzer;
	}

	public function setCharter(CharterInterface $charter)
	{
		$this->charter = $charter;
	}

	public function getReplay()
	{
		return $this->replay;
	}

	public function getChartWidth()
	{
		return $this->chartWidth;
	}

	public function setChartWidth($chartWidth)
	{
		$this->chartWidth = $chartWidth;
	}

	public function getChartHeight()
	{
		return $this->chartHeight;
	}

	public function setChartHeight($chartHeight)
	{
		$this->chartHeight = $chartHeight;
	}

	public function getChartPrecision()
	{
		return $this->chartPrecision;
	}

	public function setChartPrecision($chartPrecision)
	{
		$this->chartPrecision = $chartPrecision;
	}
}