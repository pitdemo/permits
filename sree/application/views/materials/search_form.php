
<div class="filter_form" id="filter_form" style="<?php echo $this->show_filter_form;?>;">
    <form role="form" id="form" name="form" method="post">
        <div class="row row-cards">
            <div class="col-12">          
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label"><b>Filter by</b></label>
                    <?php
                    $user_instructions=unserialize(USER_INSTRUCTIONS);
                    foreach($user_instructions as $key => $user_instruction)
                    {
                        $chk=$record_type==$key ? 'checked' : '';

                        echo '<label class="form-check form-check-inline">
                                                <input  type="radio" 
                                                name="is_loto" value="'.$key.'"  class="form-check-input record_type" data-id="'.$key.'" '.$chk.'><span class="form-check-label">'.$user_instruction.'</span>
                                        </label>';
                    }
                    ?>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                        <div class="mb-3">
                        <label class="form-label"><b>Description</b></label>
                        <input type="text" class="form-control" name="search_txt" id="search_txt" value="<?php echo (isset($search_txt) && $search_txt!='') ? $search_txt : ''; ?>" >
                        </div>
                 </div>

                 <div class="col-sm-3 col-md-3">
                        <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <input type="button" name="search" id="search" value="Search" class="btn btn-success" />        
                        </div>
                 </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        
    </form> 
    <div class="row">&nbsp;</div>
</div>