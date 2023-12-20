let loadtime: number = new Date().getTime();
const preLoaderBox: HTMLElement | null = document.querySelector("#loading");
const langDiv: HTMLElement | null = document.querySelector("#language");
const shareDivs = document.querySelectorAll(".share");
const darkBtn: HTMLElement | null = document.querySelector("#darkmode");

// CLASS
class FetchWrapper {
    private baseURL: string;
    constructor(baseURL: string) {
        this.baseURL = baseURL;
    }
    get(endpoint: string) {
        return fetch(this.baseURL + endpoint)
            .then(response => response.json());
    }
    put(endpoint: string, body: any) {
        return this.send("put", endpoint, body);
    }
    post(endpoint: string, body: any) {
        return this.send("post", endpoint, body);
    }
    delete(endpoint: string, body: any) {
        return this.send("delete", endpoint, body);
    }
    private send(method: string, endpoint: string, body: any) {
        return fetch(this.baseURL + endpoint, {
            method,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(body)
        }).then(response => response.json());
    }
}

/////////////////////// Functions ///////////////////////
const preLoader = () => {
    loadtime = new Date().getTime() - loadtime;
    console.log(loadtime + "ms");
    
    const ideal = 2000;
    const bonus = loadtime <= ideal ? ideal - loadtime : 0;
    
    setTimeout(() => {
        if (preLoaderBox) {
            Loader();
            document.querySelectorAll(".hide").forEach(hide => {
                hide.classList.remove("hide");
            });
            
            setTimeout(() => {
                darkMode();
            }, 500);
        }
    }, bonus);
  };

const Loader = () => {
    if (!preLoaderBox) {return;}
    if (preLoaderBox.style.display === "none") {
        preLoaderBox.style.display = "flex";
        preLoaderBox.style.opacity = "1"
    } else {
        preLoaderBox.style.opacity = "0";
        setTimeout(() => preLoaderBox.style.display = "none", 500);
    }
};

const shareIt = async () => {
    try {
      await navigator.share(shareData);
      console.log(shareData);
    } catch (err) {
      console.log("This browser does not support the sharing feature.");
    }
}

const darkMode = () => {
    const prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (prefers) {toggleDark();}
}

const toggleDark = () => {
    const bodyClass = document.documentElement.classList;
    bodyClass.toggle("darkmode");
    if (darkBtn) {
        const icon = bodyClass.contains("darkmode") ? 'brightness-high' : 'moon';
        darkBtn.innerHTML = `<i class="bi bi-${icon}-fill"></i>`
    }
}

const langSwitch = () => {
    console.log("nyelv");
};

const lostCalc = (db) => {
    let trans = db.translate.lost;
    let text = trans.text;
    const date = new Date(db.bio.lost);
    const now = new Date();
    const lostTime = now - date;
    const ms = Math.abs(lostTime);
    
    const seconds = Math.floor(ms / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    console.log(`${days} nap, ${hours % 24} óra, ${minutes % 60} perc, ${seconds % 60} másodperc`);

    let value;
    let unit;
    if (days >= 2) {
        value = days;
        unit = trans.d;
    } else if(hours >= 1) {
        value = hours;
        unit = trans.h;
    } else {
        value = minutes;
        unit = trans.m;
    }

    text = text.replace("${name}", db.name);
    text = text.replace("${value}", value);
    text = text.replace("${unit}", unit);

    //console.log(text);
    document.querySelector("#notify").textContent = text;
}

const clickIt = (div: HTMLElement | NodeListOf<HTMLElement> | null, func: (event: Event) => void) => {
    if (div instanceof NodeList) {
      div.forEach(item => {
        item.addEventListener("click", func);
      });
    } else if (div) {
      div.addEventListener("click", func);
    }
  }
  
/////////////////////// Add Event Listener ///////////////////////
clickIt(shareDivs, shareIt);
clickIt(langDiv, langSwitch);
clickIt(darkBtn, toggleDark);

/////////////////////// Main ///////////////////////
const petAPI = new FetchWrapper("http://localhost/redcat_api/");
petAPI.get("redcatPet?url=minta1")
    .then(data => {
        console.log(data)
        const pet = data;
        if (pet.bio.lost) {lostCalc(data)}
    })

window.addEventListener("load", preLoader);