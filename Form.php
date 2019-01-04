<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <script src="../js/jquery.js"></script>
       <script src="../js/prototype.js"></script>
       <script src="../js/vue.js"></script>
       <script src="../js/axios.min.js"></script>
       <script src="../js/qs.min.js"></script>
       <script src="../js/jquery.validate.js"></script>

        <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/localization/messages_zh.js"></script>
        <script>
            var formEleProps=['title','fieldname','fieldvalue','validation','toHide'];
            var formFieldWatch={
                       cur_fieldvalue:function(newVal,oldVal){    
                           this.$parent.formdata['field_value'][this.fieldname]=newVal
                       },
                       fieldvalue:function(newVal,oldVal){
                           this.cur_fieldvalue=newVal;
                       },
                }
            var formFieldText={
                props:formEleProps,
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                template:'<div  v-bind:class="{ hidden : toHide }"  class="details-form-field" ><div class="tips"><label class="title" >{{title}}</label> </div> <div class="content"> <input  :id=fieldname :name=fieldname  v-model="cur_fieldvalue" /> </div></div>',
                watch:formFieldWatch,          
            };
            var formFieldCheckbox={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                watch:formFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="details-form-field" ><div class="tips"><span class="title">{{title}}</span></div>  <div class="content checkbox"> <span v-for="option in cure_options"><input type="checkbox" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="option.val">{{option.label}}</label></span> </div> </div>',
            };
            var formFieldRadio={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                        cure_options:eval(this.options),
                    }
                },
                watch:formFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="details-form-field" ><div class="tips"><span class="title">{{title}}</span></div><div class="content"> <span v-for="option in cure_options"><input type="radio" :id="option.val" :value="option.val" v-model="cur_fieldvalue"><label :for="fieldname">{{option.label}}</label></span></div> </div>',
            };
            var formFieldSelect={
                props:formEleProps.concat(['options']),
                data:function(){
                    return {
                        cur_fieldvalue:this.fieldvalue,
                    }
                },
                watch:formFieldWatch,
                template:'<div v-bind:class="{hidden:toHide}"  class="details-form-field" > <div class="tips"> <label class="title" >{{title}}</label> </div> <div class="content"><select :id=fieldname :name=fieldname v-model=cur_fieldvalue> <option v-for="option in options" :value="option.val">{{option.label}}</option> </select> </div></div>',
            }
            
            
            var cmpntMsgs={
                props:['scsMsg','errorMsg'],
                template:'<ul class="messages"><li v-if=showScsMsg class="success-msg"><ul><li v-for="msg in scsMsg"><span>{{msg}}</span></li></ul></li><li v-if=showErrMsg class="error-msg"><ul><li v-for="msg in errorMsg"><span>{{msg}}</span></li></ul></li></ul>',
                computed:{
                    showScsMsg:function(){
                        var field='scsMsg';
                        return this._show(field);
                    },
                    showErrMsg:function()
                    {
                        var field='errorMsg';
                        return this._show(field);
                    },
                },
                methods:{
                    _show:function(field)
                    {
                        if(this[field] instanceof Array){
                            return this[field].length>0?true:false;
                        }else{
                            return false;
                        }
                    }
                }
            }
            
            
            var formComponents={
                'form-field-text':formFieldText,
                'form-field-select':formFieldSelect,
                'form-field-checkbox':formFieldCheckbox,
                'form-field-radio':formFieldRadio,
                'form-msgs':cmpntMsgs
            };
            
            
            Vue.component('vue-form',{
                props:['formdata',],
                components: formComponents,
                data:function(){
                    return this.formdata;
                },
                render:function(createElement){
                    return createElement("form",this.subEles(createElement))
                },
                methods:{
                    doSubmit:function(e){
                        
                        var url = this.formdata.submitUrl;
                        
                        axios({ 
                                url:url,     
                                method:'post',
                                transformRequest:[ function(data,headers){
                                        return Qs.stringify(data);
                                }],
                                data:this.formdata.field_value,
                                },
                        )
                        .then(function(response){
                            this.formdata.msgs.scsMsg=[response.data];
                            setTimeout("this.formdata.msgs=[]",3000);
                        })
                        .catch(function(error){
                            this.formdata.msgs.errorMsg=[error];
                            setTimeout("this.formdata.msgs=[]",3000);
                            console.log(error);
                        });
                    },
                    msgsElem:function(createElement)
                    {
//                        if(typeof(this.formdata.msgs)=='undefined') 
//                        {
//                            this.formdata.msgs={
//                                scsMsg:['aa','bb'],
//                                errorMsg:['cc'],
//                            }
//                        }
                        return createElement('form-msgs',{
                            props:this.formdata.msgs
                            })
                    },
                    subEles:function(createElement){
                        var eles=new Array();
                        eles.push(this.msgsElem(createElement));
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
                        var submitBt=createElement('div',{
                            attrs:{
                                class:'button-submit',
                            },
                            on:{
                                click:this.doSubmit,
                            }
                        },
                        ['save'],
                        );
                        eles.push(submitBt);
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
        <div id="app2">
        </div>
        <script>
            var formdata={
                    submitUrl:'http://test.local/JS/Vue/form/data.php',
                    msgs:{
                        'scsMsg':[],
                        'errorMsg':[],
                    },
                    field_value :{warehouse:"", country:"", email:"",'related_industry':"fashion",services_required:[]},
                    field_ele   :{
                        warehouse:{
                            title:'Warehouse',
                            type:'text',
                            toHide:true,
                        },
                        country:{
                            title:'Country',
                            type:'select',
                            options:[{val:1,'label':'A'},{val:2,'label':'B'},{val:3,'label':'C'}]
                        },
                        email:{
                            title:'Email',
                            type:'text',
                        },
                        related_industry:{
                            title:'Related Industry',
                            type:'radio',
                            options:[{val:'fashion',label:'fashion'},{val:'cosmetics',label:'cosmetics'}],
                        },
                        services_required:{
                            title:'Services Required',
                            type:'checkbox',
                            options:[{val:'warehousing',label:'warehousing'},{val:'local distribution',label:'local distribution'}],
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
        
        <script>
        var form2=new Vue({
                el:"#app2",
                render:function(createElement){
                    return createElement("vue-form",{
                        props:{formdata:formdata},
                    })
                },
            });
        </script>
    </body>
</html>
