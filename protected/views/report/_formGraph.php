<h4>กราฟเปรียบเทียบคุณภาพน้ำในกระบวนการผลิต </h4>
<div class="row-fluid">
  <div class="well span4">
    <div class="row-fluid">
        <div class="span12">
        <?php                                  
        echo CHtml::label('จุดตรวจวัด','point');  
        $models = PointsMainTb::model()->findAll(array('condition'=>'section_id="BK-SECTION-005"'));

        $typelist = CHtml::listData($models,'point_id','point_name');
        echo CHtml::dropDownList('point', '',$typelist,array('empty'=>'ทุกจุด','class'=>'span12'
                    
                        ));
        
        ?>
        </div>
    </div>   
    <div class="row-fluid">
    <div class="span6">
            <?php
            echo ' <label for="date_begin" >วันที่เริ่มต้น</label>';
            echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'name' => 'date_begin',
                        'attribute' => 'date_begin',
                        'options' => array(
                            'mode' => 'focus',
                            //'language' => 'th',
                            'format' => 'yyyy-mm-dd', //กำหนด date Format
                            'showAnim' => 'slideDown',
                        ),
                        'htmlOptions' => array('class' => 'span10'), // ใส่ค่าเดิม ในเหตุการ Update
                    )
            );
            echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
            ?>
        </div>
        <div class="span6">
            <?php
            echo ' <label for="date_end" >วันที่สิ้นสุด</label>';
            echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'name' => 'date_end',
                        'attribute' => 'date_end',
                        'options' => array(
                            'mode' => 'focus',
                            //'language' => 'th',
                            'format' => 'yyyy-mm-dd', //กำหนด date Format
                            'showAnim' => 'slideDown',
                        ),
                        'htmlOptions' => array('class' => 'span10'), // ใส่ค่าเดิม ในเหตุการ Update
                    )
            );
            echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
            ?>
        </div>
    </div>    

  </div>
  <div class="well span8">

            <?php

            $this->Widget('ext.highcharts.HighchartsWidget', array(
            'options' => array(
                'title' => array('text' => 'Fruit Consumption'),
                'xAxis' => array(
                    'categories' => array('Apples', 'Bananas', 'Oranges')
                ),
                'yAxis' => array(
                    'title' => array('text' => 'Fruit eaten')
                ),
                'series' => array(
                    array('name' => 'Jane', 'data' => array(1, 0, 4)),
                    array('name' => 'John', 'data' => array(5, 7, 3))
                )
            )
            ));


            ?>
  </div>
</div>  
