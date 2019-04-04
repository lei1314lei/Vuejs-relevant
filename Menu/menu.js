var componentMenuItem={
    props:['linkItem'],
    data:function(){
        return {
            isActive:true,
            cur_subitems:this.linkItem,
        };
    },
    template:'<li class="item" :class=linkItem.class ><span class="dropdown-icon"></span><a :href=linkItem.link>{{linkItem.title}}</a><ul class="sub-menu"><li v-for="subitem in linkItem.subitems"  class="menu-item menu-item-type-custom menu-item-object-custom"><a target="_blank"  :href=subitem.link >{{subitem.title}}</a></li></ul></li>'
}


Vue.component('vue-menu',{
    props:['menu_data'],
    components:{'menu-item':componentMenuItem} ,
    data:function(){
        return this.menu_data;
    },
    render:function(createElement){
        return createElement("ul",{ 'class':[this.class,"menu-container"],},this.subEles(createElement))
    },
    methods:{
        subEles:function(createElement){
                var eles=new Array();
                for(var i=0 ; i<this.items.length; i++)
                {
                  var ele=createElement('menu-item',{
                      props:{linkItem:this.items[i]},
                  });
                  eles.push(ele);
                }
                return eles;
        },  
    },
    })