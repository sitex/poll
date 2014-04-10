<ul class="breadcrumb">
    <li>
        <?php echo $this->Html->link(__('Manage Poll'), array('action'=>'index'));?>
        <span class="divider">/</span>
    </li>
    <li class="active"><?php echo __('View Poll'); ?></li>
</ul>
<div style="text-align:center" id="PollPieChart"></div>
<hr>
<div style="text-align:center" id="PollBarChart"></div>
<hr>
<h4><?php echo $poll['Poll']['question'];?></h4>
<p><em><?php echo $poll['Poll']['description'];?></em></p>
<?php
    $totalVote = 0;
    foreach ($poll['PollOption'] as $p) {
        $totalVote += $p['vote_count'];
    }
?>
<table class="table">
    <thead>
        <tr>
            <td>
                <strong><?php echo __('Answer');?></strong>
            </td>
             <td class="span3" style='text-align:center'>
                <strong><?php echo __('Vote Count').' ('. $totalVote.')';?></strong>
            </td>
            <td class="span4" style='text-align:center'>
                <strong><?php echo __('Percent');?></strong>
            </td>
        </tr>
    </thead>
    <tbody>
<?php
    $chartData = array();
    foreach ($poll['PollOption'] as $p) {
        $chartData[] = array($p['option'], intval($p['vote_count']));
        $percent = ($totalVote) ? round(( $p['vote_count']/$totalVote)*100) : 0;
?>
        <tr>
            <td>
                <label for='<?php echo $p['id'];?>'><?php echo $p['option'];?></label>
            </td>
            <td style='text-align:center'>
                <?php echo $p['vote_count'];?>
            </td>
            <td style='text-align:center'>
                <div class="progress progress-info span3">
                    <div class="bar" style="width: <?php echo $percent;?>%"><?php echo $percent;?>%</div>
                </div>
            </td>
        </tr>
<?php
    }
?>
    </tbody>
</table>


<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    //load the Google Visualization API and the chart
    google.load('visualization', '1', {'packages':['columnchart','piechart']});

    //set callback
    google.setOnLoadCallback (createChart);

    //callback function
    function createChart() {

        //create data table object
        var dataTable = new google.visualization.DataTable();

        //define columns for first example
        dataTable.addColumn('string');
        dataTable.addColumn('number');

        //define rows of data for first example
        dataTable.addRows(<?php echo json_encode($chartData);?>);

        //instantiate our chart objects
        var pchart = new google.visualization.PieChart (document.getElementById('PollPieChart'));
        var bchart = new google.visualization.BarChart (document.getElementById('PollBarChart'));


        //define options for visualization
        var options = {width: 600, height: 400, is3D: true, title: '<?php echo $poll['Poll']['question'];?>'};

        //draw our chart charts
        pchart.draw(dataTable, options);
        bchart.draw(dataTable, options);
    }



</script>
