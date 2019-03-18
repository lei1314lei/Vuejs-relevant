            var formEleProps=['title','fieldname','fieldvalue','validation','toHide'];
            var modelFieldWatch={
                       cur_fieldvalue:function(newVal,oldVal){    
                           this.$parent.formdata['field_value'][this.fieldname]=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                }
            var modelFieldText={
                props:formEleProps,
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                template:'<div  v-bind:class="{ hidden : toHide }"  class="model-field" ><div class="label">{{title}}</div> <div class="value">  {{cur_fieldvalue}} </div></div>',
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
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field" ><div class="label">{{title}}</div>  <div class="value checkbox"> <span v-for="option in cure_options"><input type="checkbox" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="option.val">{{option.label}}</label></span> </div> </div>',
            };
            var modelFieldRadio={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field" ><div class="label">{{title}}</div><div class="value"> <span v-for="option in cure_options"><input type="radio" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="fieldname">{{option.label}}</label></span></div> </div>',
            };
            var modelFieldSelect={
                props:formEleProps.concat(['options','readableVal']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
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
                    
                    console.log(this);
                },
                //watch:modelFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="model-field" > <div class="label">{{title}}</div> <div class="value">{{this.cur_readbleVal}}</div></div>',
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
                    return createElement("div",{attrs:{class:'vue-model-details'}},this.subEles(createElement))
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
                            var props={fieldname:field,fieldvalue:this.formdata.field_value[field]};
                            
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