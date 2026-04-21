# OSA Custom Code for PrestaShop

**Sviluppato da:** [OsaComunicare](https://osacomunicare.it)  
**Supporto:** 800 911 329  
**Versione:** 1.1.0 (DiaEvent Definitive)  
**Compatibilità:** PrestaShop 1.7.x / 8.x / 9.x  

---

## 📝 Descrizione
**OSA Custom Code** è lo strumento professionale definitivo per la gestione di snippet di codice personalizzati su PrestaShop. A differenza dei moduli standard, è progettato per garantire che nessun filtro di sicurezza del server o del database possa mai corrompere o eliminare i tuoi script grazie all'architettura basata su **File System**.

## 🛡️ La Forza della Scelta Tecnica: File System vs Database
La maggior parte dei moduli (come HTML Box o ST Custom Code) salva il codice all'interno del database. Questa pratica espone il codice a rischi costanti che il nostro modulo risolve alla radice:

* **Bypass HTMLPurifier:** Non è necessario disattivare le protezioni globali di PrestaShop per salvare script complessi.
* **Integrità del Codice:** Nessuna "pulizia" automatica o taglio dei caratteri speciali effettuato dal database o dai firewall SQL.
* **Performance:** La lettura diretta da file `.txt` è estremamente più veloce e leggera per il server rispetto a una query SQL sulla tabella `ps_configuration`.

## 🚚 Portabilità Estrema (Easy Porting)
L'architettura a file rende il trasferimento delle configurazioni tra diversi siti un'operazione da pochi secondi:

1.  Copia i file contenuti nella cartella `/modules/osacustomcode/code/` del sito sorgente.
2.  Incolla i file `.txt` (es. `head_js.txt`, `css_global.txt`, ecc.) nella cartella corrispondente del sito di destinazione.
3.  Tutte le direttive saranno immediatamente attive sul nuovo sito senza dover ricopiare manualmente il codice nelle aree di testo del modulo.

---

## ✨ Caratteristiche principali

L'interfaccia è suddivisa in tre sezioni logiche, ottimizzate con il **Verde OSA (#5F8C5E)**:

### 1. Personalizzazione CSS
* **Area dedicata:** Finestra per inserire solo direttive estetiche [cite: README
