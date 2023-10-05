document.addEventListener("DOMContentLoaded", function () {
    const datePicker = document.getElementById("date-picker");
    const selectedDate = document.getElementById("selected-date");
    const timeSlotsContainer = document.querySelector(".time-slots");
    const oldDate = document.querySelector(".old-date");
    const bookedModal = document.getElementById("bookedModal");
    const bookedMoadalName = document.getElementById("name");
    const bookedModalTitle = document.getElementById("titl");
    const bookedModalDetails = document.getElementById("desc");
    const closeBookedModal = document.getElementById("close");
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;
    let loginId;
    let afterLoginClick;
    var booked = [];
    var currentId = "";
    var currentTime = "";

    datePicker.value = formattedDate;
    selectedDate.textContent = formattedDate;
    date = formattedDate;
    console.log(date);
    function getUserId() {
        $.ajax({
            type: "GET",
            url: "get_user_id.php", 
            success: function(response) {
                var userId = response;
                loginId = userId;
            },
            error: function() {
                console.error("Failed to retrieve user_id.");
            }
        });
    }

    function checkDate() {
        const selectedDateStr = datePicker.value;

        const selectedDate = new Date(selectedDateStr);

        currentDate.setHours(0, 0, 0, 0);
        selectedDate.setHours(0, 0, 0, 0);

        if (selectedDate.getMonth() < currentDate.getMonth()) {
            return 0;
        } else if (selectedDate.getMonth() === currentDate.getMonth() && selectedDate.getDate() < currentDate.getDate()) {
            return 0;
        } else if (selectedDate.getMonth() === currentDate.getMonth() && selectedDate.getDate() === currentDate.getDate()) {
            return 1;
        } else {
            return 1;
        }
    }

    function deleteData(date, Id) {
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: {
                date: date,
                id: Id
            },
            success: function (response) {
                if (response.error) {
                    console.error("Error: " + response.error);
                } else {
                    fetchData(date);
                }
            },
            error: function () {
                console.error("AJAX request failed.");
            }
        });
    }
    function fetchData(date) {
        $.ajax({
            url: "fetch.php",
            type: "POST",
            data: {
                date: date
            },
            success: function (response) {
                const slotIds = response.split(", ");
                booked = slotIds;
                slotIds.forEach(function (slotId) {
                    const div = document.getElementById(slotId);
                    if (div) {
                        div.style.backgroundColor = "red";
                        div.textContent = "Booked";
                    }
                });
            },
            error: function () {
                console.error("AJAX request failed.");
            }
        });
    }

    function fetchDetails(Id, date) {
        $.ajax({
            url: "showDetails.php",
            type: "POST",
            data: { Id,
                    date 
                },
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    console.error("Error: " + response.error);
                } else {
                    var bookingTitle = response.bookingTitle;
                    var bookingDetails = response.bookingDetails;
                    var user_id = response.user_id;
                    afterLoginClick = user_id;
                    var userName = response.name;
                    bookedMoadalName.textContent = userName;
                    bookedModalTitle.textContent = bookingTitle;
                    bookedModalDetails.textContent = bookingDetails;
                    if(loginId == afterLoginClick) {
                        document.querySelector(".cancelBook").style.display = 'inline';
                    } 
                    else{
                        document.querySelector(".cancelBook").style.display = 'none';
                    }
                }
            },
            error: function () {
                console.error("AJAX request failed.");
            }
        });
    }

    fetchData(date);

    datePicker.addEventListener("change", function () {
        date = selectedDate.textContent = this.value;
        if (checkDate()) {
            oldDate.style.display = 'none';
            generateTimeSlots();
            fetchData(date);
            timeSlotsContainer.style.display = 'flex';
        }
        else {
            timeSlotsContainer.style.display = 'none';
            oldDate.style.display = 'flex';
        }
    });

    function generateTimeSlots() {
        timeSlotsContainer.innerHTML = "";

        const startTime = 10;

        for (let i = 0; i < 8; i++) {
            const timeSlot = document.createElement("div");
            timeSlot.classList.add("time-slot");

            const hours = Math.floor(startTime + i);
            const minutes = (startTime + i - hours) * 60;
            const timeText = formatTime(hours, minutes);


            timeSlot.textContent = timeText;
            const timeSlotId = `time-slot-${i}`;
            timeSlot.id = timeSlotId;

            timeSlot.addEventListener("click", function () {
                const date = datePicker.value;
                if (!date) {
                    alert("Please Select Date!");
                }
                else {
                    if (booked.indexOf(timeSlotId) !== -1) {
                        const Id = timeSlotId;
                        currentId = timeSlotId;
                        currentTime = timeText;
                        fetchDetails(Id, date);
                        console.log("hi");
                        showBookedModal();

                    }
                    else {
                        showModal();
                        currentId = timeSlotId;
                        currentTime = timeText;
                    }
                }
            });

            timeSlotsContainer.appendChild(timeSlot);
        }
    }

    function formatTime(hours, minutes) {
        const ampm = hours >= 12 ? "pm" : "am";
        hours = hours % 12 || 12;
        const minutesStr = minutes < 10 ? "0" + minutes : minutes;
        return `${hours}:${minutesStr} ${ampm}`;
    }

    function sendData(time, date, timeSlotId, title, description) {
        $.ajax({
            url: "process_booking.php",
            type: "POST",
            data: {
                date,
                time,
                timeSlotId,
                title,
                description
            },
            success: function (response) {
                console.log(response);
                fetchData(date);
            },
            error: function () {
                console.error("AJAX request failed.");
            }
        });
    }

    function showModal() {
        const modal = document.getElementById("bookingModal");
        modal.style.display = "flex";
    }

    function hideModal() {
        const modal = document.getElementById("bookingModal");
        modal.style.display = "none";
    }

    function showBookedModal() {
        bookedModal.style.display = "flex";
    }

    function hideBookedModal() {
        bookedModal.style.display = "none";
        document.querySelector(".cancelBook").style.display = 'none';
    }

    document.getElementById("bookingForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const time = currentTime;
        const timeSlotId = currentId;
        const date = datePicker.value;
        const title = document.getElementById("title").value;
        const description = document.getElementById("description").value;
        sendData(time, date, timeSlotId, title, description);
        document.getElementById("title").value = "";
        document.getElementById("description").value = "";
        hideModal();
    });

    document.getElementById("cancel").addEventListener("click", function (event) {
        event.preventDefault();
        hideModal();
    });

    closeBookedModal.addEventListener("click", function (event) {
        event.preventDefault();
        hideBookedModal();
    });

    document.querySelector(".cancelBook").addEventListener("click", function () {
        Id = currentId;
        deleteData(date, Id);
        hideBookedModal();
    })

    generateTimeSlots();
    getUserId()
});
