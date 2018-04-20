<?php
// $this->breadcrumbs=array(
// 	'Cl2 - Pumping Station'=>array('index'),
	
// );

?>
<script type="text/javascript">
    
  
        function getCategory(){
            return $("#section").val();
        }

</script>

<?php 
Yii::app()->clientScript->registerScript('search', "
$('#search-form form').submit(function(){
    //console.log($('#patient-grid input[name=firstname]','#patient-grid select[name=firstname]').val('x'));
   
    $.fn.yiiGridView.update('point-value-tb-grid', {
        data: $(this).serialize()
    });
    return false;
});
");


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'inline',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row-fluid">
     
      
       <div class="span3"> 
        <?php 
        
       

                $data = array();
                foreach (SectionTb::model()->findAll() as $key => $value) {
                  $data[] = array(
                                  'value'=>$value['section_id'],
                                  'text'=>$value['section_name'],
                               );
                } 
                $typelist = CHtml::listData($data,'value','text');
                echo CHtml::dropDownList('section', '', $typelist, array('class'=>'span12','empty' => '--เลือก section--',
                                            'ajax' => array(
                                                'type'=>'POST', //request type
                                                'data'=>array('section'=>'js:this.value'),
                                                'url'=>CController::createUrl('./pointsMainTb/getCategoryList'),        
                                                'update'=>'#category', //selector to update
                                        
                                            )
                                        ));
                //echo $form->dropDownListRow($model, 'point_id', $typelist,array('class'=>'span12','empty'=>"")); 

         ?>
       </div>
       <div class="span2"> 
        <?php 
        
       

                $data = array();
                // foreach (CategoryTb::model()->findAll() as $key => $value) {
                //   $data[] = array(
                //                   'value'=>$value['category_id'],
                //                   'text'=>$value['category_title'],
                //                );
                // } 
                $typelist = CHtml::listData($data,'value','text');
                echo CHtml::dropDownList('category', '', $typelist, array('class'=>'span12','empty' => '--เลือก category--',
                                            'ajax' => array(
                                                'type'=>'POST', //request type
                                                'data'=>array('section'=>'js:getCategory()','category'=>'js:this.value'),
                                                'url'=>CController::createUrl('./pointsMainTb/getPointList'),        
                                                'update'=>'#PointValueTb_point_id', //selector to update
                                        
                                            )
                                        ));
               

         ?>
       </div>
       <div class="span2"> 
        <?php 
        
       

                $data = array();
                
                $typelist = CHtml::listData($data,'value','text');
                echo CHtml::dropDownList('PointValueTb[point_id]', '', $typelist, array('class'=>'span12','empty' => '--เลือก point--'));
                //echo $form->dropDownListRow($model, 'point_id',$typelist, array('class'=>'span12','empty' => '--เลือก point--'));

         ?>
       </div>
     
        <div class="span2">
            <?php
          
            echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'name' => 'PointValueTb[datetime_record]',
                        'attribute' => 'PointValueTb[datetime_record]',
                        'options' => array(
                            'mode' => 'focus',
                            //'language' => 'th',
                            'format' => 'yyyy-mm-dd', //กำหนด date Format
                            'showAnim' => 'slideDown',
                        ),
                        'htmlOptions' => array('class' => 'span12'), // ใส่ค่าเดิม ในเหตุการ Update
                    )
            );
            echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
            ?>
        </div>
       
        <?php
             


                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'warning',
                    'label'=>'ค้นหา',
                    'icon'=>'search white',
                // 'url'=>array('update'),
                    'htmlOptions'=>array('class'=>'span2 pull-right search-button'),
                ));

              
        ?>
      
       
    </div>
    
<?php $this->endWidget(); ?>


<br>
<?php 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'Export to Excel',
    'icon'=>'plus-sign',
    'url'=>array('dailyReport'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
)); 


$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'point-value-tb-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		'checkbox'=> array(
        	    'id'=>'selectedID',
            	'class'=>'CCheckBoxColumn',
            	//'selectableRows' => 2, 
        		 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
	  	         'htmlOptions'=>array(
	  	            	  			'style'=>'text-align:center'

	  	            	  		)   	  		
        ),
        'section'=>array(
                'name' => 'section_id',
                
                'header' => 'section',
                'value' => array($model,'getSectionName'),
                //'filter'=>CHtml::activeTextField($model, 'point_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("point_id"))),
                //'value'=>'$data->category_id',
                //'value'=>'PointsMainTb::Model()->FindByPk($data->owner_id)->name',
                'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),                       
                'htmlOptions'=>array('style'=>'text-align:left;')
        ),
        'category'=>array(
                'name' => 'category_id',
                
                'header' => 'category',
                'value' => array($model,'getCategoryName'),
                //'filter'=>CHtml::activeTextField($model, 'point_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("point_id"))),
                //'value'=>'$data->category_id',
                //'value'=>'PointsMainTb::Model()->FindByPk($data->owner_id)->name',
                'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),                       
                'htmlOptions'=>array('style'=>'text-align:left;')
        ),
		'point_id'=>array(
			    'name' => 'point_id',
			    //'filter'=>CHtml::activeTextField($model, 'point_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("point_id"))),
				'value' => array($model,'getPointName'),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
	  	'datetime_record'=>array(
			   
			    'name'=>'datetime_record',
			    'value' => array($model,'getDate'),
			    //'filter'=>CHtml::activeTextField($model, 'datetime_record',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("datetime_record"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
		'point_value'=>array(
                'name' => 'point_float_value',
                'value' => array($model,'getValue'),
			    //'filter'=>CHtml::activeTextField($model, 'point_value',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("point_value"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:right;padding-right:10px')
	  	),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
            'template' => '{update} {delete}',
    
        )
	),
));


?>
