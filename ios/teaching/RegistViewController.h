//
//  RegistViewController.h
//  teaching
//
//  Created by kidliuxu on 14-1-6.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "BaseViewController.h"
#import "UIKidPickerView.h"

@interface RegistViewController : BaseViewController <UITextFieldDelegate, UIPickerViewDataSource, UIPickerViewDelegate, UIKidPickerViewDelegate>
{
    CGFloat contentViewHeight;
    int scrolViewHeight;
    NSString *departmentID;
}


@property (nonatomic, retain) UITapGestureRecognizer *tapGr;
@property (nonatomic, retain) UITextField *emailField;
@property (nonatomic, retain) UITextField *usernameField;
@property (nonatomic, retain) UITextField *passwordField;
@property (nonatomic, retain) UITextField *rePasswordField;
@property (nonatomic, retain) UIButton *departmentBtn;
@property (nonatomic, retain) NSArray *departmentNameList;
@property (nonatomic, retain) NSArray *departmentIdList;

@end
