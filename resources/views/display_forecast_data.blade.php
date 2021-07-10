<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI mkt display data</title>

    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 80%;
          text-align: center;
        }
        
        td, th {
          border: 1px solid black;
          text-align: left;
          padding: 8px;
          text-align: center;
        }
        
        tr:nth-child(1) {
          background-color:#d4d9d5;
        }
        </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>

<table>
    <tr>
        <th>reception_date</th>
        <th>cashback</th>
    </tr>

</table>

<script>

function insertAfter(referenceNode, newNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

//sleep() func definition    
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var obj, requestOptions = {
    method: 'GET',
    redirect: 'follow'
  };
  
  fetch("https://ai-marketing-cashback-forecast.herokuapp.com/api/cashbacksDate", requestOptions)
.then(res => res.json())
        .then(data => obj = data)
        .then(() => console.log(obj))
        .then(function() 
        { 
            
        // add new attribute "reception_cb_date" to each sale JSON

            for(i=1;i<=12;i++){

        try{
            for(j=0;j<obj[`0${i}`].length;j++){

                var payment_delay=obj[`0${i}`][j].payment_delay;
                var reception_cb_date = new Date(obj[`0${i}`][j].sale_date);
                reception_cb_date.setDate(reception_cb_date.getDate()+payment_delay);
                obj[`0${i}`][j].reception_cb_date=reception_cb_date;
                obj[`0${i}`][j].reception_cb_month=monthNames[reception_cb_date.getMonth()];

            }
        }catch(e){
            // console.log(e)
        }
        
        }

        //All sale rows per reception_cb_date
        var cashbacks=[]

        for(q=1;q<=12;q++){
            try{
                for(k=0;k<obj[`0${q}`].length;k++){
                
                    var day=obj[`0${q}`][k].reception_cb_date.getDate()
                    var month=monthNames[obj[`0${q}`][k].reception_cb_date.getMonth()]
                    cashbacks.push(`${day}-${month}`)
                
                }
            }catch(e){
                // console.log(e)
            }
        }
        cashbacks.sort()

        //Unique days in array
        var uniqueDays = [...new Set(cashbacks)];  
        console.log(cashbacks);
        console.log(uniqueDays);

        //Unique days+item count set at zero in array
        var forecast=[]

        for (l=0;l<uniqueDays.length;l++){
            forecast.push(
                {
                    "day":uniqueDays[l],
                    "items":0,
                    "cashback":0
                })
            }

        //Set the correct count of cashbacks per day
        for (m=0;m<uniqueDays.length;m++){

            for(r=1;r<=12;r++){

            try {

                for(n=0;n<obj[`0${r}`].length;n++){
                    
                    var day=obj[`0${r}`][n].reception_cb_date.getDate();
                    var month=monthNames[obj[`0${r}`][n].reception_cb_date.getMonth()];
                    var date=`${day}-${month}`;

                    if(date == uniqueDays[m])
                    {
                        forecast[m].items+=1
                        forecast[m].cashback+=obj[`0${r}`][n].cashback
                        // console.log("uniqueDays[m] :"+uniqueDays[m]+" date = "+date)

                    }
                }
            } catch (e) {
                // console.log(e)
            }

            }
        }

        //Keep only 2 decimals for the cashback number
        for(s=0;s<forecast.length;s++){
        forecast[s].cashback=(Math.round(((forecast[s].cashback) + Number.EPSILON) * 100) / 100)
        }

        console.log(forecast)
        var thead=document.querySelector("body > table > tbody > tr:nth-child(1)")

        for(t=0;t<forecast.length;t++){
            var tr=document.createElement('tr');
            var reception_date=document.createElement('td')
            var cashback=document.createElement('td')
            reception_date.innerHTML=forecast[t].day
            cashback.innerHTML=forecast[t].cashback
            insertAfter(thead,tr)
            tr.appendChild(reception_date)
            tr.appendChild(cashback)
        }

        console.log("forecast length : "+forecast.length)
        
        //Data below to be used for the graph data cashback data per month
        
        var cashbackMonths=[];
        var cashbackMonthsAmount=[];

        for(i=1;i<=12;i++){

                cashbackMonthsAmount[`${monthNames[i-1]}`]=
                    {
                    "month":monthNames[i-1],
                    "cashback":0
                    }
                
                cashbackMonths[`0${i}`]=monthNames[i-1]

        }
        console.log(cashbackMonths)

        //convert object cashbackMonths to Array
        cashbackMonths=Object.values(cashbackMonths)

        for(i=1;i<=12;i++){

            try{
                for(j=0;j<obj[`0${i}`].length;j++){

                    if(cashbackMonths.includes(obj[`0${i}`][j].reception_cb_month)){

                        var month=obj[`0${i}`][j].reception_cb_month;
                        cashbackMonthsAmount[`${month}`].cashback += obj[`0${i}`][j].cashback;
                    }

                }
            }catch(e){
                // console.log(e)
            }
            
        }


        //adjust 2 decimals for cashbackMonthsAmount.cashback values 

        var monthlyCBdataset=[];

        for (var key in cashbackMonthsAmount) {
            console.log(cashbackMonthsAmount[key].cashback=(Math.round(((cashbackMonthsAmount[key].cashback) + Number.EPSILON) * 100) / 100));
            monthlyCBdataset.push(cashbackMonthsAmount[key].cashback)
        }

        console.log(cashbackMonthsAmount)
        console.log(monthlyCBdataset)

        //Chart cashback data display per month

        const labels = monthNames;

        const data = {
            labels: labels,
            datasets: [{
                label: 'Cashback forecast',
                data: monthlyCBdataset,
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        },
        };
        // === include 'setup' then 'config' above ===

        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        
        });
 
        /**
        * 
        Use chart.js for display
        https://www.chartjs.org/docs/latest/charts/bar.html
        * 
        */
//
//


</script>
</body>
</html>