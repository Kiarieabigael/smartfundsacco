-- Users Table
CREATE TABLE users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('Admin', 'Loan Officer', 'Member') NOT NULL
);

INSERT INTO users (Username, Email, Password, Role) 
VALUES ('John Doe', 'johndoe@example.com', 'securepassword123', 'Member');

-- Loan Table
CREATE TABLE Loan (
    LoanID INT PRIMARY KEY AUTO_INCREMENT,
    MemberID INT,
    LoanAmount DECIMAL(10,2),
    InterestRate DECIMAL(5,2),
    LoanTerm INT,
    LoanStatus ENUM('Pending', 'Approved', 'Rejected', 'Repaid'),
    RepaymentDate DATE,
    FOREIGN KEY (MemberID) REFERENCES users(UserID) ON DELETE CASCADE
);

INSERT INTO Loan (MemberID, LoanAmount, InterestRate, LoanTerm, LoanStatus, RepaymentDate) VALUES
(3, 5000.00, 5.5, 12, 'Pending', '2025-03-18'),
(4, 10000.00, 6.0, 24, 'Approved', '2026-03-18');

-- Loan Approvals Table
CREATE TABLE LoanApprovals (
    ApprovalID INT PRIMARY KEY AUTO_INCREMENT,
    LoanID INT,
    ApprovedBy INT,
    ApprovalStatus ENUM('Approved', 'Rejected', 'Pending'),
    ApprovalDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Comments TEXT,
    FOREIGN KEY (LoanID) REFERENCES Loan(LoanID) ON DELETE CASCADE,
    FOREIGN KEY (ApprovedBy) REFERENCES users(UserID) ON DELETE SET NULL
);

INSERT INTO LoanApprovals (LoanID, ApprovedBy, ApprovalStatus, Comments) VALUES
(2, 2, 'Approved', 'Loan approved based on credit history.');

-- Loan Collateral Table
CREATE TABLE LoanCollateral (
    CollateralID INT PRIMARY KEY AUTO_INCREMENT,
    LoanID INT,
    AssetType VARCHAR(255),
    AssetValue DECIMAL(10,2),
    Status ENUM('Pending', 'Approved', 'Rejected'),
    FOREIGN KEY (LoanID) REFERENCES Loan(LoanID) ON DELETE CASCADE
);

INSERT INTO LoanCollateral (LoanID, AssetType, AssetValue, Status) VALUES
(1, 'Car', 8000.00, 'Pending'),
(2, 'House', 25000.00, 'Approved');

-- Repayments Table
CREATE TABLE Repayments (
    RepaymentID INT PRIMARY KEY AUTO_INCREMENT,
    LoanID INT NOT NULL,
    AmountPaid DECIMAL(15, 2) NOT NULL,
    PaymentDate DATE NOT NULL,
    RemainingBalance DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (LoanID) REFERENCES Loan(LoanID) ON DELETE CASCADE
);

INSERT INTO Repayments (LoanID, AmountPaid, PaymentDate, RemainingBalance) VALUES
(2, 1000.00, '2025-04-18', 9000.00);

-- Savings Table
CREATE TABLE Savings (
    SavingsID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT NOT NULL,
    DepositedMoney DECIMAL(15, 2) DEFAULT 0,
    WithdrawnMoney DECIMAL(15, 2) DEFAULT 0,
    Balance DECIMAL(15, 2) DEFAULT 0,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE
);

INSERT INTO Savings (UserID, DepositedMoney, WithdrawnMoney, Balance) VALUES
(1, 2000.00, 500.00, 1500.00),
(2, 5000.00, 1000.00, 4000.00);

-- Transactions Table
CREATE TABLE Transactions (
    TransactionID INT PRIMARY KEY AUTO_INCREMENT,
    LoanID INT,
    TransactionType ENUM('Disbursement', 'Repayment'),
    Amount DECIMAL(10,2),
    TransactionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (LoanID) REFERENCES Loan(LoanID) ON DELETE CASCADE
);

INSERT INTO Transactions (LoanID, TransactionType, Amount) VALUES
(2, 'Disbursement', 10000.00),
(2, 'Repayment', 1000.00);
