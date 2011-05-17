SC2Chart - Building charts for SC2Replays - PHP 5.3
===================================================

Usage
-----

    use SC2Chart\SC2Chart;
    use SC2Chart\Bridge\SC2Replay\Analyzer;     // the library you want to use. Be sure that the proper library is loaded
    use SC2Chart\Charter\GDCharter;             // the charter you want to use. Only libGD available yet

    // creating dependencies
    $analyzer = new Analyzer();
    $charter = new GDCharter();

    // creating chart
    $sc2chart = new SC2chart($analyzer, $charter);
    $sc2chart->populate($src_replay, $dest_chart_filepath);

    // options
    $sc2chart->setChartWidth();     // width of your graph
    $sc2chart->setChartHeight();    // height of your graph
    $sc2chart->setChartPrecision(); // precision you want to apply, from 1 to 60. If you set precision to 1, you will get apm for every seconds, your chart maybe pixellised.

You can your own analyzers and charters if u want to do so.

Implementing an analyzer
------------------------

    use SC2Chart\Analyzer\AnalyzerInterface;
    use SC2Chart\Analyzer\AbstractAnalyzer;     // if you want help :p

    class myAnalyzer extends AbstractAnalyzer implements AnalyzerInterface
    {
        /**
         * Implement this method to transform a replay file to an object
         * This object must be an instance of a class implementing SC2Chart\Replay\ReplayInterface
         *
         * @param   string              $replayFile     Path to the source replay file
         * @return  ReplayInterface     $replay
         */
        public function buildReplay($replayFile)
        {
            // ...
        }
    }

Implementing an charter
-----------------------

    use SC2Chart\Chart\CharterInterface;

    class myCharter implements CharterInterface
    {
        /**
         * Implement this method to transform a ReplayInterface into a chart.
         *
         * @param   ReplayInterface     $replay     The Replay object to process
         * @param   string              $filename   The name of the image chart to create
         * @param   SC2Chart            $sc2chart   The core object, here to access configuration variables
         * @return  null
         */
        public function create(ReplayInterface $replay, $filename, SC2Chart $sc2chart)
        {
            // ...
        }
    }

You can also extends the SC2Chart\Chart\GDChart class. I'll try to clean up that class so that it'll be easier to customize.

Todo
----

- debug debug debug
- write PHPUnit tests
- enable colors personnalization
- enable custom fonts


Requirements
------------

PHP 5.3 rules !

Author
------

Antoine Berranger - <antoine@ihqs.net> - <http://twitter.com/ihqs>

License
-------

SC2Chart is licensed under the MIT License - see the LICENSE file for details
