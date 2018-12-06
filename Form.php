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
    
        
        
<!--        <form id="vueForm">
            <form-field-text fieldname="warehouse"  v-bind:fieldvalue="warehouse"></form-field-text>
            <form-field-select fieldname='country' v-bind:fieldvalue="country" v-bind:options="options"></form-field-select>
        </form>-->
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
            Vue.component('form-field-select',{
                props:['fieldname','fieldvalue','options'],
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
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
                render:function(createElement){
                    var labelEle=createElement("label",{
                        attrs:{
                            'for':this.fieldname
                        }
                    },[this.fieldname]);
                    
                    var selectEle=createElement("select",{
                        attrs:{
                            name:this.fieldname,
                            value:this.cur_fieldvalue,
                        }
                    },this.subEles(createElement));
                    
                    var divEle= createElement("div",{
                            attrs:{
                                class:'details-form-field'
                            }
                        },
                        [ labelEle , selectEle ]
                    )
                    return divEle;
                },
                methods:{
                    subEles:function(createElement){
                        var optEles=new Array();
                        optEles.push(createElement('option',["Please Select"]));
                        for(var i in this.options)
                        {
                            var ele=createElement('option',{
                                    attrs:{
                                       value:this.options[i]['val'],
                                    }
                                 },
                                [this.options[i]['valtext']]
                            )
                            optEles.push(ele);
                        }
                        return optEles;
                    },
                },
            });
            
            
            Vue.component('vue-form',{
                props:['formdata'],
                data:function(){
                    return this.formdata;
                },
                //template:'<form > </form>',
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
//                            console.log(i);
//                            console.log(this.formdata[i]);
                        }
                        
                        return eles;
//                        
//                        return [createElement('h1', '一则头条'),'b'] ;
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
                            value:1,
                            options:[
                                {val:1,'valtext':'A'},
                                {val:2,'valtext':'B'}
                            ],
                        }
                    },
                },

            });
    
//            Vue.component('form-field-select',{
//                props:{
//                    fieldname:String,
//                    fieldvalue:String,
//                    options:{},
//                },
//                data:function(){
//                    return {
//                        val:'',
//                    }
//                },
//                template:'<select :id=fieldname :name=fieldname v-model=this.val> <option    >a</option></select>',
//
//            })
//            
//            
//            
//            
//            
//            
//            
//            
//            
//            
//            
//            
//            Vue.component('slct-opt',{
//                props:['val','valText'],
//                template:'<option v-bind:value="val">{{valText}}</option>',
//            });
//            
//            
//            
//            Vue.component('form-field-text',{
//                props:{
//                    fieldname:String,
//                    fieldvalue:String
//                },
//                data:function(){
//                    return {
//                        cur_value:this.fieldvalue,
//                    }
//                },
//                template:'<div class="details-form-field"><label v-bind:for="fieldname">{{fieldname}}</label><input :id="fieldname" :name="fieldname" type="text" v-model="cur_value"/> </div>',
//                watch:{
//                    fieldvalue:function(newVal,oldVal){
//                        this.cur_value=newVal;
//                    },
//                    cur_value:function(newVal,oldVal){
//                        this.$parent.$data[this.fieldname]=newVal;
//                    },
//                },
//            });
//    
//    
//
//    
//    
//    
//            var form=new Vue({
//                el:"#vueForm",
//                data:{
//                    warehouse:{
//                        type:'text',
//                        value:"",
//                    },
//                    country:{
//                        type:'select',
//                        value:'',
//                        options:[
//                            {val:1,'valtext':'A'},
//                            {val:2,'valtext':'B'}
//                        ],
//                    }
//                },
//
//            });

        </script>
    </body>
</html>