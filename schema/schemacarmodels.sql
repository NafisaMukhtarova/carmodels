CREATE TABLE car_brands (
    id INT NOT NULL AUTO_INCREMENT,
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,

    car_brand_name VARCHAR(100),
    brand_photo VARCHAR(50),
    
    PRIMARY KEY(id),
    UNIQUE(car_brand_name)
);



CREATE TABLE car_models(
    id INT NOT NULL AUTO_INCREMENT,
                            car_model_name VARCHAR(100),
                            car_brand INT,
                        PRIMARY KEY(car_model_id),
                        FOREIGN KEY(car_brand) REFERENCES car_brands (car_brand_id) 
);


CREATE TABLE body_types(body_type_id INT NOT NULL AUTO_INCREMENT,
                            body_type VARCHAR(100),
                        PRIMARY KEY(body_type_id)
                        );


CREATE TABLE cars(car_id INT NOT NULL AUTO_INCREMENT,
                        car_name VARCHAR(100),
                        car_model INT,
                        body_type INT,
                        modification VARCHAR(100),
                        capacity INT,
                        year_of_issue YEAR(4),
                        year_end YEAR(4),
                    PRIMARY KEY(car_id),
                    FOREIGN KEY(car_model) REFERENCES car_models(car_model_id),
                    FOREIGN KEY(body_type) REFERENCES body_types(body_type_id));
CREATE TABLE car_photos(photo_id INT NOT NULL AUTO_INCREMENT,
                            car_id INT,
                            brand_photo VARCHAR(50),
                        PRIMARY KEY(photo_id),
                        FOREIGN KEY (car_id)REFERENCES cars(car_id));