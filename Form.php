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
            <vue-form :formdata=formdata ></vue-form>
        </div>
        <script>
            Vue.component('form-field-text',{
                props:['fieldname','fieldvalue','validation'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                template:'<div class="details-form-field" ><label >{{fieldname}}</label> <input  :id=fieldname :name=fieldname  v-model="cur_fieldvalue" /> </div>',
                watch:{
                       cur_fieldvalue:function(newVal,oldVal){    
                           this.$parent.$data['field_value'][this.fieldname]=newVal
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
                           this.$parent.$data['field_value'][this.fieldname]=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                },
                template:'<div class="details-form-field" ><label >{{fieldname}}</label> <select :id=fieldname :name=fieldname v-model=cur_fieldvalue> <option v-for="option in cure_options" :value="option.val">{{option.valtext}}</option> </select></div>',
            });
            
            Vue.component('vue-form',{
                props:['formdata',],
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    return createElement("form",this.subEles(createElement))
                },
                beforeUpdate:function(){
                },
                methods:{
                    subEles:function(createElement){
                        var eles=new Array();
                        console.log(this.formdata.field_ele)
                        for(var field in this.formdata.field_ele)
                        {
                            console.log(field )
                            var type=this.formdata.field_ele[field].type;
                            var cpntName='form-field-'+type;
                            var props={
                                    fieldname:field,
                                    fieldvalue:this.formdata.field_value[field],
                                };
                            if(type=='select'){
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
            
            var form=new Vue({
                el:"#app",
                data:{
                    formdata:{
                        field_value:{
                            warehouse:"",
                            country:"",
                            email:"",
                        },
                        field_ele:{
                            warehouse:{
                                type:'text',
                            },
                            country:{
                                type:'select',
                                options:[
                                    {val:1,'valtext':'A'},
                                    {val:2,'valtext':'B'},
                                    {val:3,'valtext':'C'}
                                ]
                            },
                            email:{
                                type:'text',
                            },
                        },
                        field_validation:{
                            rules:{
                                warehouse:{},
                                country:{},
                                email:{},
                            },
                        }
                    }
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