<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
    </head>
    <body>
        <div id="app">
            <vue-form v-bind:formdata=formdata></vue-form>
        </div>
        <script>
            Vue.component('form-field-text',{
                props:['fieldname','fieldvalue','validation'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        inputHtml:'',
                    }
                },
                template:'<div class="details-form-field" ><label >{{fieldname}}</label> <input  :id=fieldname :name=fieldname  v-model="cur_fieldvalue" /> </div>',
                watch:{
                       cur_fieldvalue:function(newVal,oldVal){      
                           this.$parent.$data[this.fieldname]['value']=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                }
            })
            
            Vue.component("form-field-select",{
                props:['fieldname','fieldvalue','validation','options'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                watch:{
                       cur_fieldvalue:function(newVal,oldVal){       
                           this.$parent.$data[this.fieldname]['value']=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                },
                template:'<div class="details-form-field" ><label >{{fieldname}}</label> <select :id=fieldname :name=fieldname v-model=cur_fieldvalue> <option v-for="option in cure_options" :value="option.val">{{option.valtext}}</option> </select></div>',
            });
            
            Vue.component('vue-form',{
                props:['formdata'],
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    return createElement("form",this.subEles(createElement))
                },
                beforeUpdate:function(){
                },
                mounted:function(){
                     this.iniValidation();
                },
                methods:{
                    iniValidation:function(){
                        var rules={};
                        var messages={};
                        for(var field in this.formdata)
                        {
                            if ('validation' in this.formdata[field])
                            {
                                var validation = this.formdata[field].validation;
                                rules[field]=validation.rules;
                                messages[field]=validation.messages;
                            }

                        }
                        
   
                        // jQuery("form").validate();
                    },
                    subEles:function(createElement){
                        var eles=new Array();
                        for(var i in this.formdata)
                        {
                            var type=this.formdata[i].type;
                            var cpntName='form-field-'+type;
                            var props={
                                    fieldname:i,
                                    fieldvalue:this.formdata[i].value,
                                    validation:this.formdata[i].validation,
                                };
                            if(type=='select'){
                               props.options=this.formdata[i].options;
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
            
            var form=new Vue({
                el:"#app",
                data:{
                    formdata:{
                        warehouse:{
                            type:'text',
                            value:"",
                        },
                        country:{
                            type:'select',
                            value:'',
                            options:[
                                {val:1,'valtext':'A'},
                                {val:2,'valtext':'B'},
                                {val:3,'valtext':'C'}
                            ],
                        },
                        email:{
                            type:'text',
                            value:'',
                        }
                    },
                },

            });
            
            var validations=
             {
                rules:{
                    warehouse:{
                        required:true,
                    },
                    email:{
                        required:true,
                        email:true
                    }
                }
            } ;
           jQuery("form").validate(validations);
        </script>
    </body>
</html>