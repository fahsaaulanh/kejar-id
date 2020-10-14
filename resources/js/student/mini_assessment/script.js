// On Load
const data = [
    {
        id: '1',
        name: 'Subject 1'
    },
    {
        id: '2',
        name: 'Subject 2'
    },
    {
        id: '3',
        name: 'Subject 3'
    },
];

const title = localStorage.getItem('pts_title') || '';
$('#breadcrumb-1').html(title);
$('#title').html(title);
//

function renderLoading() {
    return `
        <div class="row justify-content-center">
            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="mt-2 row justify-content-center">
            <h5>Loading</h5>
        </div>
    `;
}

function renderSubjects(data = []) {
    return data.map((d, index) => `
        <div class="row mt-4">
            <div
                class="btn-accordion"
                data-toggle="collapse"
                data-target="#accordion-${index}"
                aria-controls="accordion-${index}"
                role="button"
            >
                <h4>
                    <i class="kejar-matrikulasi">kejar-mapel</i>
                    ${d.name}
                </h4>
            </div>
            <div class="collapse w-100" id="accordion-${index}">
                <div class="btn-accordion-item" role="button">
                    <h4 class="text-reguler">
                        Kelas 10
                    </h4>
                    <h4 class="text-reguler pt-2">
                        <i class="kejar-matirkulasi">kejar-right</i>
                    </h4>
                </div>
            </div>
        </div>
    `);
}
//

// API Call Function
async function saveAll() {
    const promisesSave = data.map((d) => fetchSubjects(data));

    await Promise.all(promises);
    console.log('success');
}

function fetchSubjects(url) {
    console.log('Fetch');
    $.ajax({
        url,
        beforeSend: function() {
            console.log('Start Fetch');
            $('#accordion-pts').html(renderLoading())
        },
        success: function(result){
            console.log('Finish Fetch');
            $('#accordion-pts').html(renderSubjects(data))
        }
    });
}
//

// On Function
//
