

<script>
     import {Doughnut} from 'vue-chartjs'
     import ChartDataLabels from 'chartjs-plugin-datalabels'

     Chart.helpers.merge(Chart.defaults.global.plugins.datalabels, {color: 'black'})

     export default {
         extends: Doughnut,
         plugins: ChartDataLabels ,
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
                 /*this.renderChart({
                     labels: this.headers,
                     datalabels: {
                         labels: {
                             title: {
                                 font: {
                                     weight: 'bold'
                                 }
                             }
                         }
                     },
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
                     hoverBorderColor: 'blue',
                     /!*borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                         'rgba(28, 255, 1, 255)',
                         'rgba(173, 0, 255, 255)',
                         'rgba(0, 255, 180, 255)',
                         'rgba(0, 32, 22, 255)',
                 ],*!/
                     borderWidth: 1,
                 })*/
                 this.renderChart({
                         labels: this.headers,
                         datasets:[{
                             label: 'бла бла',
                             backgroundColor: ['#F44336','#9C27B0','#3F51B5','#009688','#4CAF50','#CDDC39','#FFC107'],
                             datalabels: {
                                 labels: {
                                     title: {
                                         font: {
                                             weight: 'bold',
                                         }
                                     }
                                 }
                             },
                             data: this.masiv,
                             hoverBorderColor: 'blue',
                         }]
                     },
                     {
                         responsive: true,
                         maintainAspectRatio: false,
                         tooltips:{
                             enabled: false
                         },
                         title:{
                             display:true,
                             text:'по видам причин ГС'
                         },
                         legend:{
                             display: true,
                             position: 'bottom',
                             labels:{
                                 fontColor: '#263238'
                             }
                         },
                         plugins:{
                             datalabels:{
                                 color: 'white',
                                 labels:{
                                     title:{
                                         font:{
                                             weight: 'bold'
                                         }
                                     },
                                     value:{
                                         color: 'green'
                                     }
                                 }
                             }
                         }
                     })
             }
         },
         mounted () {
             this.renderChart({
                 labels: this.headers,
                 datasets:[{
                     label: 'бла бла',
                     backgroundColor: ['#F44336','#9C27B0','#3F51B5','#009688','#4CAF50','#CDDC39','#FFC107'],
                     data: this.masiv
                 }]
             },
                 {
                     responsive: true,
                     maintainAspectRatio: false
                 })
         },
     }
</script>
