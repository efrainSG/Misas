import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class LocationService {
  private apiURL = "http://localhost/api/locaciones";
  
  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get<any[]>(this.apiURL);
  }

  getById(id: number) {
    return this.http.get<any>(`${this.apiURL}/${id}`);
  }

  getByColonia(coloniaId: number) {
    return this.http.get<any[]>(`${this.apiURL}/byColonia/${coloniaId}`);
  }

  create(location: any) {
    return this.http.post(this.apiURL, location);
  }
}
