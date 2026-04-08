import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class TipoLocacionService {
  private apiURL = "http://localhost/api/tipoLocaciones";

  private fakeData = [
    { Id: 1, Nombre: 'Basílica' },
    { Id: 2, Nombre: 'Parroquia' },
    { Id: 3, Nombre: 'Capilla' },
  ];

  constructor(private http: HttpClient) {}

  getAll() {
    //return this.http.get<any[]>(this.apiURL);
    return new Promise<any[]>((resolve) => {
      setTimeout(() => {
        resolve(this.fakeData);
      }, 500); // Simula un retraso de 500ms
    });

  }
}
