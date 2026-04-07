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

  create(location: any) {
    return this.http.post(this.apiURL, location);
  }
}
