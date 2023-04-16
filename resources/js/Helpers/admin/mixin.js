export default {
    data(){
        return{
            msg : 'hi from mixin'
        }
    },

    methods:{
        callApi(method, url, dataObj){
            try{
               return axios({
                    method: method,
                    url: url,
                    data:dataObj

                });
            }catch(e){
                console.log(e);
            }
        }
    }
}
