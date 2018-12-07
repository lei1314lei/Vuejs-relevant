<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    </head>
    <body>
        <div id="app">
            <vue-form v-bind:formdata=formdata></vue-form>
        </div>
        <script>
            Vue.component('form-field-text',{
                props:['fieldname','fieldvalue'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                template:'<div class="details-form-field" ><label >{{fieldname}}</label><input :id=fieldname :name=fieldname type="text" v-model="cur_fieldvalue"/> </div>',
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
                props:['fieldname','fieldvalue','options'],
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
                template:'<div class="details-form-field" ><label >{{fieldname}}</label> <select :id=fieldname v-model=cur_fieldvalue> <option v-for="option in cure_options" :value="option.val">{{option.valtext}}</option> </select></div>',
            });
            
            Vue.component('vue-form',{
                props:['formdata'],
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    return createElement("form",this.subEles(createElement))
                },
                methods:{
                    subEles:function(createElement){
                        var eles=new Array();
                        for(var i in this.formdata)
                        {
                            var type=this.formdata[i].type;
                            var cpntName='form-field-'+type;
                            var props={
                                    fieldname:i,
                                    fieldvalue:this.formdata[i].value,
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
                        }
                    },
                },

            });

        </script>
    </body>
</html>