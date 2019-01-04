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
        <script src="./form.js"></script>
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
