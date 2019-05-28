@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Importação</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            {{--<a class="btn btn-app" onclick="$('#send').trigger('click')">--}}
                                {{--<i class="fa fa-save"></i> Salvar--}}
                            {{--</a>--}}
                            <a class="btn btn-app">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Importação<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left" id="formImport"    method="post"   enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div id="wizard" class="form_wizard wizard_horizontal" >
                                    <ul class="wizard_steps">
                                        <li>
                                            <a href="#step-1">
                                                <span class="step_no">1</span>
                                                <span class="step_descr">Layout</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-2">
                                                <span class="step_no">2</span>
                                                <span class="step_descr">Arquivos</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-3">
                                                <span class="step_no">3</span>
                                                <span class="step_descr">Validação</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-4">
                                                <span class="step_no">4</span>
                                                <span class="step_descr">Importação</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="step-1"  >
                                        <div class="item form-group" id="divLayout" style="height: 40px"></div>
                                        <div class="item form-group" id="divLayout" style="height: 100px" >
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId" >Layout <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="LayoutId" name="LayoutId" required="required" onchange="montaArquivo(this.value)">
                                                    <option value=""></option>
                                                    @foreach($Layout as $var)
                                                        <option value="{{$var->LayoutId}}">{{$var->LayoutNm}}</option>             
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-2"  style="min-height: 450px" >
                                        <p id="p-step-2">Carregando ...</p>
                                    </div>
                                    <div id="step-3" style="min-height: 450px">
                                        <div class="col-md-12">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content bs-example-popovers">
                                                    <p id="p-step-3">Carregando...</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-4" style="min-height: 450px">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script>
        /*
 * SmartWizard 3.3.1 plugin
 * jQuery Wizard control Plugin
 * by Dipu
 *
 * Refactored and extended:
 * https://github.com/mstratman/jQuery-Smart-Wizard
 *
 * Original URLs:
 * http://www.techlaboratory.net
 * http://tech-laboratory.blogspot.com
 */

        function SmartWizard(target, options) {
            this.target       = target;
            this.options      = options;
            this.curStepIdx   = options.selected;
            this.steps        = $(target).children("ul").children("li").children("a"); // Get all anchors
            this.contentWidth = 0;
            this.msgBox = $('<div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>');
            this.elmStepContainer = $('<div></div>').addClass("stepContainer");
            this.loader = $('<div>Loading</div>').addClass("loader");
            this.buttons = {
                next : $('<a>'+options.labelNext+'</a>').attr("href","#").addClass("buttonNext"),
                previous : $('<a>'+options.labelPrevious+'</a>').attr("href","#").addClass("buttonPrevious"),
                finish  : $('<a>'+options.labelFinish+'</a>').attr("href","#").addClass("buttonFinish")
            };

            /*
             * Private functions
             */

            var _init = function($this) {
                var elmActionBar = $('<div></div>').addClass("actionBar");
                elmActionBar.append($this.msgBox);
                $('.close',$this.msgBox).click(function() {
                    $this.msgBox.fadeOut("normal");
                    return false;
                });

                var allDivs = $this.target.children('div');
                // CHeck if ul with steps has been added by user, if not add them
                if($this.target.children('ul').length == 0 ){
                    var ul = $("<ul/>");
                    target.prepend(ul)

                    // for each div create a li
                    allDivs.each(function(i,e){
                        var title = $(e).first().children(".StepTitle").text();
                        var s = $(e).attr("id")
                        // if referenced div has no id, add one.
                        if (s==undefined){
                            s = "step-"+(i+1)
                            $(e).attr("id",s);
                        }
                        var span = $("<span/>").addClass("stepDesc").text(title);
                        var li = $("<li></li>").append($("<a></a>").attr("href", "#" + s).append($("<label></label>").addClass("stepNumber").text(i + 1)).append(span));
                        ul.append(li);
                    });
                    // (re)initialise the steps property
                    $this.steps = $(target).children("ul").children("li").children("a"); // Get all anchors
                }
                $this.target.children('ul').addClass("anchor");
                allDivs.addClass("content");

                // highlight steps with errors
                if($this.options.errorSteps && $this.options.errorSteps.length>0){
                    $.each($this.options.errorSteps, function(i, n){
                        $this.setError({ stepnum: n, iserror:true });
                    });
                }

                $this.elmStepContainer.append(allDivs);
                elmActionBar.append($this.loader);
                $this.target.append($this.elmStepContainer);

                for( var btnIndex in $this.options.buttonOrder)
                {
                    if(!$this.options.buttonOrder.hasOwnProperty(btnIndex))
                    {
                        continue;
                    }

                    switch($this.options.buttonOrder[btnIndex])
                    {
                        case 'finish':
                            elmActionBar.append($this.buttons.finish);
                            break;
                        case 'next':
                            elmActionBar.append($this.buttons.next);
                            break;
                        case 'prev':
                            elmActionBar.append($this.buttons.previous);
                            break;
                    }
                }

                $this.target.append(elmActionBar);
                this.contentWidth = $this.elmStepContainer.width();

                $($this.buttons.next).click(function() {
                    $this.goForward();
                    return false;
                });
                $($this.buttons.previous).click(function() {
                    $this.goBackward();
                    return false;
                });
                $($this.buttons.finish).click(function() {
                    if(!$(this).hasClass('buttonDisabled')){
                        if($.isFunction($this.options.onFinish)) {
                            var context = { fromStep: $this.curStepIdx + 1 };
                            if(!$this.options.onFinish.call(this,$($this.steps), context)){
                                return false;
                            }
                        }else{
                            var frm = $this.target.parents('form');
                            if(frm && frm.length){
                                frm.submit();
                            }
                        }
                    }
                    return false;
                });

                $($this.steps).bind("click", function(e){
                    if($this.steps.index(this) == $this.curStepIdx){
                        return false;
                    }
                    var nextStepIdx = $this.steps.index(this);
                    var isDone = $this.steps.eq(nextStepIdx).attr("isDone") - 0;
                    if(isDone == 1){
                        _loadContent($this, nextStepIdx);
                    }
                    return false;
                });

                // Enable keyboard navigation
                if($this.options.keyNavigation){
                    $(document).keyup(function(e){
                        if(e.which==39){ // Right Arrow
                            $this.goForward();
                        }else if(e.which==37){ // Left Arrow
                            $this.goBackward();
                        }
                    });
                }
                //  Prepare the steps
                _prepareSteps($this);
                // Show the first slected step
                _loadContent($this, $this.curStepIdx);
            };

            var _prepareSteps = function($this) {
                if(! $this.options.enableAllSteps){
                    $($this.steps, $this.target).removeClass("selected").removeClass("done").addClass("disabled");
                    $($this.steps, $this.target).attr("isDone",0);
                }else{
                    $($this.steps, $this.target).removeClass("selected").removeClass("disabled").addClass("done");
                    $($this.steps, $this.target).attr("isDone",1);
                }

                $($this.steps, $this.target).each(function(i){
                    $($(this).attr("href").replace(/^.+#/, '#'), $this.target).hide();
                    $(this).attr("rel",i+1);
                });
            };

            var _step = function ($this, selStep) {
                return $(
                    $(selStep, $this.target).attr("href").replace(/^.+#/, '#'),
                    $this.target
                );
            };

            var _loadContent = function($this, stepIdx) {
                var selStep = $this.steps.eq(stepIdx);
                var ajaxurl = $this.options.contentURL;
                var ajaxurl_data = $this.options.contentURLData;
                var hasContent = selStep.data('hasContent');
                var stepNum = stepIdx+1;
                if (ajaxurl && ajaxurl.length>0) {
                    if ($this.options.contentCache && hasContent) {
                        _showStep($this, stepIdx);
                    } else {
                        var ajax_args = {
                            url: ajaxurl,
                            type: $this.options.ajaxType,
                            data: ({step_number : stepNum}),
                            dataType: "text",
                            beforeSend: function(){
                                $this.loader.show();
                            },
                            error: function(){
                                $this.loader.hide();
                            },
                            success: function(res){
                                $this.loader.hide();
                                if(res && res.length>0){
                                    selStep.data('hasContent',true);
                                    _step($this, selStep).html(res);
                                    _showStep($this, stepIdx);
                                }
                            }
                        };
                        if (ajaxurl_data) {
                            ajax_args = $.extend(ajax_args, ajaxurl_data(stepNum));
                        }
                        $.ajax(ajax_args);
                    }
                }else{
                    _showStep($this,stepIdx);
                }
            };

            var _showStep = function($this, stepIdx) {
                var selStep = $this.steps.eq(stepIdx);
                var curStep = $this.steps.eq($this.curStepIdx);
                if(stepIdx != $this.curStepIdx){
                    if($.isFunction($this.options.onLeaveStep)) {
                        var context = { fromStep: $this.curStepIdx+1, toStep: stepIdx+1 };
                        if (! $this.options.onLeaveStep.call($this,$(curStep), context)){
                            return false;
                        }
                    }
                }
                $this.elmStepContainer.height(_step($this, selStep).outerHeight());
                var prevCurStepIdx = $this.curStepIdx;
                $this.curStepIdx =  stepIdx;
                if ($this.options.transitionEffect == 'slide'){
                    _step($this, curStep).slideUp("fast",function(e){
                        _step($this, selStep).slideDown("fast");
                        _setupStep($this,curStep,selStep);
                    });
                } else if ($this.options.transitionEffect == 'fade'){
                    _step($this, curStep).fadeOut("fast",function(e){
                        _step($this, selStep).fadeIn("fast");
                        _setupStep($this,curStep,selStep);
                    });
                } else if ($this.options.transitionEffect == 'slideleft'){
                    var nextElmLeft = 0;
                    var nextElmLeft1 = null;
                    var nextElmLeft = null;
                    var curElementLeft = 0;
                    if(stepIdx > prevCurStepIdx){
                        nextElmLeft1 = $this.elmStepContainer.width() + 10;
                        nextElmLeft2 = 0;
                        curElementLeft = 0 - _step($this, curStep).outerWidth();
                    } else {
                        nextElmLeft1 = 0 - _step($this, selStep).outerWidth() + 20;
                        nextElmLeft2 = 0;
                        curElementLeft = 10 + _step($this, curStep).outerWidth();
                    }
                    if (stepIdx == prevCurStepIdx) {
                        nextElmLeft1 = $($(selStep, $this.target).attr("href"), $this.target).outerWidth() + 20;
                        nextElmLeft2 = 0;
                        curElementLeft = 0 - $($(curStep, $this.target).attr("href"), $this.target).outerWidth();
                    } else {
                        $($(curStep, $this.target).attr("href"), $this.target).animate({left:curElementLeft},"fast",function(e){
                            $($(curStep, $this.target).attr("href"), $this.target).hide();
                        });
                    }

                    _step($this, selStep).css("left",nextElmLeft1).show().animate({left:nextElmLeft2},"fast",function(e){
                        _setupStep($this,curStep,selStep);
                    });
                } else {
                    _step($this, curStep).hide();
                    _step($this, selStep).show();
                    _setupStep($this,curStep,selStep);
                }
                return true;
            };

            var _setupStep = function($this, curStep, selStep) {
                $(curStep, $this.target).removeClass("selected");
                $(curStep, $this.target).addClass("done");

                $(selStep, $this.target).removeClass("disabled");
                $(selStep, $this.target).removeClass("done");
                $(selStep, $this.target).addClass("selected");

                $(selStep, $this.target).attr("isDone",1);

                _adjustButton($this);

                if($.isFunction($this.options.onShowStep)) {
                    var context = { fromStep: parseInt($(curStep).attr('rel')), toStep: parseInt($(selStep).attr('rel')) };
                    if(! $this.options.onShowStep.call(this,$(selStep),context)){
                        return false;
                    }
                }
                if ($this.options.noForwardJumping) {
                    // +2 == +1 (for index to step num) +1 (for next step)
                    for (var i = $this.curStepIdx + 2; i <= $this.steps.length; i++) {
                        $this.disableStep(i);
                    }
                }
            };

            var _adjustButton = function($this) {
                if (! $this.options.cycleSteps){
                    if (0 >= $this.curStepIdx) {
                        $($this.buttons.previous).addClass("buttonDisabled");
                        if ($this.options.hideButtonsOnDisabled) {
                            $($this.buttons.previous).hide();
                        }
                    }else{
                        $($this.buttons.previous).removeClass("buttonDisabled");
                        if ($this.options.hideButtonsOnDisabled) {
                            $($this.buttons.previous).show();
                        }
                    }
                    if (($this.steps.length-1) <= $this.curStepIdx){
                        $($this.buttons.next).addClass("buttonDisabled");
                        if ($this.options.hideButtonsOnDisabled) {
                            $($this.buttons.next).hide();
                        }
                    }else{
                        $($this.buttons.next).removeClass("buttonDisabled");
                        if ($this.options.hideButtonsOnDisabled) {
                            $($this.buttons.next).show();
                        }
                    }
                }
                // Finish Button
                $this.enableFinish($this.options.enableFinishButton);
            };

            /*
             * Public methods
             */

            SmartWizard.prototype.goForward = function(){
                var nextStepIdx = this.curStepIdx + 1;
                if (this.steps.length <= nextStepIdx){
                    if (! this.options.cycleSteps){
                        return false;
                    }
                    nextStepIdx = 0;
                }
                _loadContent(this, nextStepIdx);
            };

            SmartWizard.prototype.goBackward = function(){
                var nextStepIdx = this.curStepIdx-1;
                if (0 > nextStepIdx){
                    if (! this.options.cycleSteps){
                        return false;
                    }
                    nextStepIdx = this.steps.length - 1;
                }
                _loadContent(this, nextStepIdx);
            };

            SmartWizard.prototype.goToStep = function(stepNum){
                var stepIdx = stepNum - 1;
                if (stepIdx >= 0 && stepIdx < this.steps.length) {
                    _loadContent(this, stepIdx);
                }
            };
            SmartWizard.prototype.enableStep = function(stepNum) {
                var stepIdx = stepNum - 1;
                if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
                    return false;
                }
                var step = this.steps.eq(stepIdx);
                $(step, this.target).attr("isDone",1);
                $(step, this.target).removeClass("disabled").removeClass("selected").addClass("done");
            }
            SmartWizard.prototype.disableStep = function(stepNum) {
                var stepIdx = stepNum - 1;
                if (stepIdx == this.curStepIdx || stepIdx < 0 || stepIdx >= this.steps.length) {
                    return false;
                }
                var step = this.steps.eq(stepIdx);
                $(step, this.target).attr("isDone",0);
                $(step, this.target).removeClass("done").removeClass("selected").addClass("disabled");
            }
            SmartWizard.prototype.currentStep = function() {
                return this.curStepIdx + 1;
            }

            SmartWizard.prototype.showMessage = function (msg) {
                $('.content', this.msgBox).html(msg);
                this.msgBox.show();
            }

            SmartWizard.prototype.enableFinish = function (enable) {
                // Controll status of finish button dynamically
                // just call this with status you want
                this.options.enableFinishButton = enable;
                if (this.options.includeFinishButton){
                    if (!this.steps.hasClass('disabled') || this.options.enableFinishButton){
                        $(this.buttons.finish).removeClass("buttonDisabled");
                        if (this.options.hideButtonsOnDisabled) {
                            $(this.buttons.finish).show();
                        }
                    }else{
                        $(this.buttons.finish).addClass("buttonDisabled");
                        if (this.options.hideButtonsOnDisabled) {
                            $(this.buttons.finish).hide();
                        }
                    }
                }
                return this.options.enableFinishButton;
            }

            SmartWizard.prototype.hideMessage = function () {
                this.msgBox.fadeOut("normal");
            }
            SmartWizard.prototype.showError = function(stepnum) {
                this.setError(stepnum, true);
            }
            SmartWizard.prototype.hideError = function(stepnum) {
                this.setError(stepnum, false);
            }
            SmartWizard.prototype.setError = function(stepnum,iserror) {
                if (typeof stepnum == "object") {
                    iserror = stepnum.iserror;
                    stepnum = stepnum.stepnum;
                }

                if (iserror){
                    $(this.steps.eq(stepnum-1), this.target).addClass('error')
                }else{
                    $(this.steps.eq(stepnum-1), this.target).removeClass("error");
                }
            }

            SmartWizard.prototype.fixHeight = function(){
                var height = 0;

                var selStep = this.steps.eq(this.curStepIdx);
                var stepContainer = _step(this, selStep);
                stepContainer.children().each(function() {
                    if($(this).is(':visible')) {
                        height += $(this).outerHeight(true);
                    }
                });

                // These values (5 and 20) are experimentally chosen.
                stepContainer.height(height + 5);
                this.elmStepContainer.height(height + 20);
            }

            _init(this);
        };



        (function($){

            $.fn.smartWizard = function(method) {
                var args = arguments;
                var rv = undefined;
                var allObjs = this.each(function() {
                    var wiz = $(this).data('smartWizard');
                    if (typeof method == 'object' || ! method || ! wiz) {

                        // show deprecated message for includeFinishButton  and reverseButtonsOrder options
                        if(method.hasOwnProperty('includeFinishButton') || method.hasOwnProperty('reverseButtonsOrder'))
                        {
                            console.log("[WARNING] Parameter 'includeFinishButton' and 'reverseButtonsOrder' are " +
                                "deprecated an will be removed in the next release. Use option 'buttonOrder' instead.");
                        }

                        var options = $.extend({}, $.fn.smartWizard.defaults, method || {});

                        // handle deprecated reverseButtonsOrder option
                        if(options.reverseButtonsOrder === true)
                        {
                            options.buttonOrder.reverse()
                        }

                        // handle deprecated includeFinishButton option
                        if(options.includeFinishButton === false)
                        {
                            var index = options.buttonOrder.indexOf('finish');
                            if (index > -1) {
                                options.buttonOrder.splice(index, 1);
                            }
                        }

                        if (! wiz) {
                            wiz = new SmartWizard($(this), options);
                            $(this).data('smartWizard', wiz);
                        }
                    } else {
                        if (typeof SmartWizard.prototype[method] == "function") {
                            rv = SmartWizard.prototype[method].apply(wiz, Array.prototype.slice.call(args, 1));
                            return rv;
                        } else {
                            $.error('Method ' + method + ' does not exist on jQuery.smartWizard');
                        }
                    }
                });
                if (rv === undefined) {
                    return allObjs;
                } else {
                    return rv;
                }
            };

// Default Properties and Events
            $.fn.smartWizard.defaults = {
                selected: 0,  // Selected Step, 0 = first step
                keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
                enableAllSteps: false,
                transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
                contentURL:null, // content url, Enables Ajax content loading
                contentCache:true, // cache step contents, if false content is fetched always from ajax url
                cycleSteps: false, // cycle step navigation
                enableFinishButton: false, // make finish button enabled always
                hideButtonsOnDisabled: false, // when the previous/next/finish buttons are disabled, hide them instead?
                errorSteps:[],    // Array Steps with errors
                labelNext:'Next',
                labelPrevious:'Previous',
                labelFinish:'Finish',
                noForwardJumping: false,
                ajaxType: "POST",
                onLeaveStep: null, // triggers when leaving a step
                onShowStep: null,  // triggers when showing a step
                onFinish: null,  // triggers when Finish button is clicked
                includeFinishButton : true,   // Add the finish button
                reverseButtonsOrder: false, //shows buttons ordered as: prev, next and finish
                buttonOrder: ['finish', 'next', 'prev']  // button order, to hide a button remove it from the list
            };

        })(jQuery);
    </script>
    <script>
        function init_SmartWizard() {
            "undefined" != typeof $.fn.smartWizard && (console.log("init_SmartWizard"),
                $("#wizard").smartWizard({
                    buttonOrder: ['prev','next','finish'],
                    labelNext:'Próximo', // label for Next button
                    labelPrevious:'Voltar', // label for Previous button
                    labelFinish:'Finalizar',
                    hideButtonsOnDisabled:true,
                    onLeaveStep:leaveAStepCallback,
                    onFinish:onFinishCallback
                }),

                $(".buttonNext").addClass("btn btn-success"), $(".buttonPrevious").addClass("btn btn-primary"), $(".buttonFinish").addClass("btn btn-default"))
        }
        function leaveAStepCallback(obj, context){
            //alert("Leaving step " + context.fromStep + " to go to step " + context.toStep);
;
            return validateSteps(context.fromStep,context.toStep); // return false to stay on step and true to continue navigation
        }

        function onFinishCallback(objs, context){
            if(validateAllSteps()){
                $('form').submit();
            }
        }

        // Your Step validation logic
        function validateSteps(stepnumber,tostep){
            var isStepValid = true;
            // validate step 1
            if(stepnumber == 1){
                if($('#LayoutId').val()<1){
                    swal({
                        title: 'Erro!',
                        html: 'Selecione um Layout!',
                        type: 'error'
                    })
                    isStepValid=false;
                }

            }
            if(stepnumber == 2 && tostep >= 3){
                isStepValid=false;
                $( ".imp_arquivo" ).each(function( index ) {
                    if($(this).val().length>0){
                        isStepValid=true;
                    }
                });
                if(!isStepValid) {
                    swal({
                        title: 'Erro!',
                        html: 'Escolha um arquivo!',
                        type: 'error'
                    })
                }else{
                    $( "#formImport" ).submit();
                }
            }
            return isStepValid;
        }
        function validateAllSteps(){
            var isStepValid = true;
            // all step validation logic
            return isStepValid;
        }
            $(document).ready(function(){
                init_SmartWizard();

            });
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' name='"+$(this).children('input').attr('name')+"' accept='.csv, .txt, .xml' class='input-ghost'  required=\"required\" style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                            element.next(element).find('input').prop('required',true);
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                            $(this).parents(".input-file").find('input').prop('required',false);
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }
        $(function() {
            bs_input_file();
        });
        function montaArquivo(LayoutId) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                data: {
                    _token: '{!! csrf_token() !!}',
                    LayoutId:LayoutId,
                    _method: 'POST'
                },
                url: '{{ url('admin/implayout/montaarquivo/') }}',
                success: function (retorno) {
                    $('#ArquivoId').children().remove();
                    if(retorno) {
                        var arquivos = JSON.parse(JSON.stringify(retorno));
                        $('#p-step-2').html('');
                        $.each(arquivos, function( index, value ) {
                            $('#p-step-2').append(
'                               <div class="item form-group">\n' +
'                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">'+value['ArquivoDs']+'</label>\n' +
'                                    <div class="col-md-6 col-sm-6 col-xs-12">\n' +
'                                        <div class="form-group">\n' +
'                                            <div class="input-group input-file">\n' +
'                                                <input type="text"  name="imp_arquivo'+value["ArquivoId"]+'"  id="imp_arquivo'+value["ArquivoId"]+'"  class="form-control imp_arquivo" />\n' +
'                                                <span class="input-group-btn">\n' +
'                                                    <button class="btn btn-default btn-choose" type="button">...</button>\n' +
'                                                </span>\n' +
'                                            </div>\n' +
'                                        </div>\n' +
'                                    </div>\n' +
'                                </div>'
                            );
                        });
                        bs_input_file();
                    }
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        }

        $("#formImport").on("submit", function(e) {
            e.preventDefault();
            $('#p-step-3').html('');
            $('#p-step-3').html('Carregando...');
            var form_data = new FormData();

            var files =$('input[type=file]');
            console.log(files.length);

            for(var i=0;i<files.length;i++){
                var file =files[i].files;
                if(file.length>0)
                form_data.append(files[i].name,file[0], file[0]['name']);

            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':'{!! csrf_token() !!}',
                }
            });

            $.ajax({
                url:'{{ url('admin/importacao/') }}' ,
                data: form_data,
                type: 'POST',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                success: function(retorno) {
                    var obj = $.parseJSON(retorno);
                    var err=0;
                    $('#p-step-3').html('')
                    $.each(obj, function (i,v)
                    {
                        if(i=='erros'){
                            $.each(v, function (i2,v2) {
                                $('#p-step-3').append(
                                    '<div class="alert alert-danger alert-dismissible fade in" role="alert">\n' +

                                    '<strong>' + v2 + '\n' +
                                    '</div>'
                                );
                                err=err+1;
                            });
                        }

                    });
                    if(err==0){
                        $('#p-step-3').append(
                            '<div class="alert alert-success alert-dismissible fade in" role="alert">\n' +
                            '<strong>Ok, não foi encontrado nenhum erro!\n' +
                            '</div>'
                        );
                    }
                }
            });
        });
    </script>

@endpush