<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<!--        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>  -->
       <script src="./prototype.js"></script>
        <script src="./vue.js"></script>
         
        
        
       
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
        <script>
            Vue.component('form-field-text',{
                props:['title','fieldname','fieldvalue','validation'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                template:'<div class="details-form-field" ><label class="title" >{{title}}</label> <input  :id=fieldname :name=fieldname  v-model="cur_fieldvalue" /> </div>',
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
                props:['title','fieldname','fieldvalue','validation','options'],
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
                template:'<div class="details-form-field" ><label class="title" >{{title}}</label> <select :id=fieldname :name=fieldname v-model=cur_fieldvalue> <option v-for="option in cure_options" :value="option.val">{{option.valtext}}</option> </select></div>',
            });
            
            
            Vue.component("form-field-checkbox",{
                props:['title','fieldname','fieldvalue','options'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                created:function(){
                    console.log(this.$data);
                },
                watch:{
                       cur_fieldvalue:function(newVal,oldVal){       
                           this.$parent.$data['field_value'][this.fieldname]=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                },
                template:'<div class="details-form-field" ><span class="title">{{title}}</span><span v-for="option in cure_options"><input type="checkbox" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="fieldname">{{option.label}}</label></span>{{cur_fieldvalue}}</div>',
            })
            
            Vue.component('vue-form',{
                props:['formdata',],
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    return createElement("form",this.subEles(createElement))
                },
                methods:{
                    subEles:function(createElement){
                        var eles=new Array();
                        for(var field in this.formdata.field_ele)
                        {
                            var type=this.formdata.field_ele[field].type;
                            var cpntName='form-field-'+type;
                            var props={
                                    title:this.formdata.field_ele[field]['title'],
                                    fieldname:field,
                                    fieldvalue:this.formdata.field_value[field],
                                };
                            if(type=='select'){
                               props.options=this.formdata.field_ele[field].options;
                            }    
                            else if(type=='checkbox')
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
        </script>
    </head>
    <body>
        <div id="app">
            <vue-form :formdata=formdata ></vue-form>
        </div>
        <script>
            var formdata={
                    field_value :{warehouse:"", country:"", email:"",'related_industry':["fashion"]},
                    field_ele   :{
                        warehouse:{
                            title:'Warehouse',
                            type:'text',
                        },
                        country:{
                            title:'Country',
                            type:'select',
                            options:[{val:1,'valtext':'A'},{val:2,'valtext':'B'},{val:3,'valtext':'C'}]
                        },
                        email:{
                            title:'Email',
                            type:'text',
                        },
                        related_industry:{
                            title:'Related Industry',
                            type:'checkbox',
                            options:[{val:'fashion',label:'fashion'},{val:'cosmetics',label:'cosmetics'}],
                        },
                    },
                    field_validation:{
                        rules:{
                            warehouse:{ required:true,},
                            country:{},
                            email:{required:true,email:true
                            },
                        },
                    }
                };
            var form=new Vue({
                el:"#app",
                data:{
                    formdata:formdata
                },
            });
           jQuery("form").validate(formdata.field_validation);
        </script>
    </body>
</html>