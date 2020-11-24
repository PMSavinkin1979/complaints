

<script>
     import {Doughnut} from 'vue-chartjs'
     import labels from 'chartjs-plugin-labels'
     Vue.use(labels)

     export default {
         extends: Doughnut,

         props:{
             masiv:{
                 type:Array,
                 default: null
             },
             headers:{
                 type:Array,
                 default: null
             },
         },
         watch:{
             masiv(){
                 console.log('Из AnyChart')
                 this.renderChart({
                     labels: this.headers,
                     datasets: [{
                         data: this.masiv,
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(28, 255, 1, 255)',
                             'rgba(173, 0, 255, 255)',
                             'rgba(0, 255, 180, 255)',
                             'rgba(0, 32, 22, 255)',
                         ],
                         /*borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                     ],*/
                         borderWidth: 1
                     }],
                     /*options:{
                         plugins:{
                             labels:{
                                 rendel: 'label',
                                 fontColor: '#000',
                                 position: 'outside'
                             }
                         }
                     }*/
                 })

             }
         },
         mounted () {
             this.renderChart({
                 labels: this.headers,
                 datasets: [{
                     //label: 'Данные 1',
                     data: this.masiv,
                     backgroundColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         'rgba(28, 255, 1, 255)',
                         'rgba(173, 0, 255, 255)',
                         'rgba(0, 255, 180, 255)',
                         'rgba(0, 32, 22, 255)',
                     ],
                     /*borderColor: [
                     'rgba(255, 99, 132, 1)',
                     'rgba(54, 162, 235, 1)',
                     'rgba(255, 206, 86, 1)',
                 ],*/
                     borderWidth: 1
                 }],
                 responsive: true,
                 maintainAspectRatio: false
             })
         },
     }
</script>
