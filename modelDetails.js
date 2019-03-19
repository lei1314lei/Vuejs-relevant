            var formEleProps=['title','fieldname','fieldvalue','validation','toHide','classes'];
            var getClassForModelEles = function (classes,classForEle){
                        var classStrForEachEle=' ';
                        var hasCustomClassesForEle=classes.hasOwnProperty(classForEle);
                        if(hasCustomClassesForEle)
                        {
                            var classForhField=classes[classForEle];
                            for (var i=0;i<classForhField.length;i++){
                                classStrForEachEle +=" "+classForhField[i];
                            }
                            classStrForEachEle;
                        }
                        return classStrForEachEle;
            }
//            var modelFieldWatch={
//                       cur_fieldvalue:function(newVal,oldVal){    
//                           this.$parent.formdata['field_value'][this.fieldname]=newVal
//                       },
//                       fieldvalue:function(newVal,oldVal){
//                           this.cur_fieldvalue=newVal;
//                       },
//                }
            var modelFieldText={
                props:formEleProps,
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                created:function (){
                    this.cur_customClassForField=getClassForModelEles(this.classes,'for_ele_field');
                    this.cur_customClassForLabel=getClassForModelEles(this.classes,'for_ele_label');
                    this.cur_customClassForVal=getClassForModelEles(this.classes,'for_ele_val');
                },
                template:'<div  v-bind:class="{ hidden : toHide }"  class="model-field" :class="cur_customClassForField"><div class="label" :class="cur_customClassForLabel">{{title}}</div> <div class="value" :class="cur_customClassForVal">  {{cur_fieldvalue}} </div></div>',
                //watch:modelFieldWatch,          
            };
            var modelFieldCheckbox={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                created:function (){
                    this.cur_customClassForField=getClassForModelEles(this.classes,'for_ele_field');
                    this.cur_customClassForLabel=getClassForModelEles(this.classes,'for_ele_label');
                    this.cur_customClassForVal=getClassForModelEles(this.classes,'for_ele_val');
                },
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field" :class="cur_customClassForField"><div class="label" :class="cur_customClassForLabel">{{title}}</div>  <div class="value checkbox" :class="cur_customClassForVal"> <span v-for="option in cure_options"><input type="checkbox" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="option.val">{{option.label}}</label></span> </div> </div>',
            };
            var modelFieldRadio={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                        cur_customClassForField:this.customClassForField,
                    }
                },
                created:function (){
                    
                     this.cur_readbleVal='';
                    if(typeof(this.fieldvalue)!='undefined')
                    {
                        for(fieldvalue in this.options)
                        {
                            if(fieldvalue==this.fieldvalue)
                            {

                                this.cur_readbleVal=this.options[fieldvalue].label;
                                break;
                            }
                        }
                    }

                    
                    this.cur_customClassForField=getClassForModelEles(this.classes,'for_ele_field');
                    this.cur_customClassForLabel=getClassForModelEles(this.classes,'for_ele_label');
                    this.cur_customClassForVal=getClassForModelEles(this.classes,'for_ele_val');
                },
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field" :class="cur_customClassForField" ><div class="label" :class="cur_customClassForLabel">{{title}}</div><div class="value" :class="cur_customClassForVal"> {{cur_readbleVal}}</div> </div>',
            };
            var modelFieldSelect={
                props:formEleProps.concat(['options','readableVal']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cur_customClassForField:this.customClassForField,
                    }
                },
                created:function()
                {
                    for(fieldvalue in this.options)
                    {
                        if(fieldvalue==this.fieldvalue)
                        {
                            this.cur_readbleVal=this.options[fieldvalue].label;
                            break;
                        }
                    }
                    this.cur_customClassForField=getClassForModelEles(this.classes,'for_ele_field');
                    this.cur_customClassForLabel=getClassForModelEles(this.classes,'for_ele_label');
                    this.cur_customClassForVal=getClassForModelEles(this.classes,'for_ele_val');
                },
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field"  :class="cur_customClassForField"> <div class="label" :class="cur_customClassForLabel">{{title}}</div> <div class="value" :class="cur_customClassForVal">{{this.cur_readbleVal}}</div></div>',
            }
            
            
//            var cmpntMsgs={
//                props:['scsMsg','errorMsg'],
//                template:'<ul class="messages"><li v-if=showScsMsg class="success-msg"><ul><li v-for="msg in scsMsg"><span>{{msg}}</span></li></ul></li><li v-if=showErrMsg class="error-msg"><ul><li v-for="msg in errorMsg"><span>{{msg}}</span></li></ul></li></ul>',
//                computed:{
//                    showScsMsg:function(){
//                        var field='scsMsg';
//                        return this._show(field);
//                    },
//                    showErrMsg:function()
//                    {
//                        var field='errorMsg';
//                        return this._show(field);
//                    },
//                },
//                methods:{
//                    _show:function(field)
//                    {
//                        if(this[field] instanceof Array){
//                            return this[field].length>0?true:false;
//                        }else{
//                            return false;
//                        }
//                    }
//                }
//            }
            
            
            var modelComponents={
                'form-field-text':modelFieldText,
                'form-field-select':modelFieldSelect,
                'form-field-checkbox':modelFieldCheckbox,
                'form-field-radio':modelFieldRadio,
               // 'form-msgs':cmpntMsgs
            };
            
            
            Vue.component('vue-model-details',{
                props:['formdata',],
                components: modelComponents,
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    var classStr='model-details';
                    var hasCustomClasses=this.formdata.hasOwnProperty("classes");
                    if(hasCustomClasses)
                    {
//                        var classes=this.formdata.classes;
//                        var hasCustomClassesForEle=classes.hasOwnProperty("for_ele_details");
//                        if(hasCustomClassesForEle)
//                        {
//                            var classForDetailsContainer=classes.for_ele_details;
//                            for (var i=0;i<classForDetailsContainer.length;i++){
//                                classStr +=" "+classForDetailsContainer[i];
//                            }
//                        }
                        classStr+=getClassForModelEles(this.formdata.classes,"for_ele_details");
                        
//                        var classStrForEachEle=' ';
//                        var hasCustomClassesForEle=classes.hasOwnProperty("for_ele_field");
//                        if(hasCustomClassesForEle)
//                        {
//                            var classForhField=classes.for_ele_field;
//                            for (var i=0;i<classForhField.length;i++){
//                                classStrForEachEle +=" "+classForhField[i];
//                            }
//                            this.customClassForField=classStrForEachEle;
//                        }
//                        var classStrForEachEle=' ';
//                        var hasCustomClassesForEle=classes.hasOwnProperty("for_ele_val");
//                        if(hasCustomClassesForEle)
//                        {
//                            var customClassesForEle=classes.for_ele_label;
//                            for (var i=0;i<customClassesForEle.length;i++){
//                                classStrForEachEle +=" "+customClassesForEle[i];
//                            }
//                            this.customClassForLabel=classStrForEachEle;
//                        }
//                        
//                        var classStrForEachEle=' ';
//                        var hasCustomClassesForEle=classes.hasOwnProperty("for_ele_val");
//                        if(hasCustomClassesForEle)
//                        {
//                            var customClassesForEle=classes.for_ele_val;
//                            for (var i=0;i<customClassesForEle.length;i++){
//                                classStrForEachEle +=" "+customClassesForEle[i];
//                            }
//                            this.customClassForVal=classStrForEachEle;
//                        }
                        
                    }

                    
                    
                    return createElement("div",{attrs:{class:classStr}},this.subEles(createElement))
                },
                methods:{
                    msgsElem:function(createElement)
                    {
                        return createElement('form-msgs',{
                            props:this.formdata.msgs
                            })
                    },
                    subEles:function(createElement){
                        var eles=new Array();
                      //  eles.push(this.msgsElem(createElement));
                        for(var field in this.formdata.field_ele)
                        {
                            var type=this.formdata.field_ele[field].type;
                            var cpntName='form-field-'+type;
                            var props={fieldname:field,fieldvalue:this.formdata.field_value[field],classes:this.formdata.classes};
                            
                            for(var attr in this.formdata.field_ele[field])
                            {
                               props[attr]=this.formdata.field_ele[field][attr];
                            }
                            
                            if(type=='select'){
                               props.options=this.formdata.field_ele[field].options;
                            }    
                            else if(type=='checkbox' || type=='radio')
                            {
                                props.options=this.formdata.field_ele[field].options;
                            }
                            var ele=createElement(cpntName,{
                                props:props
                            });
                            eles.push(ele);
                        }
                        return eles;
                    },
                }
            })   