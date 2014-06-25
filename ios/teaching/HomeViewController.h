//
//  HomeViewController.h
//  teaching
//
//  Created by merlin on 13-12-18.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "BaseViewController.h"
#import "UICheckBox.h"
#import "UICheckBoxGroup.h"
#import "LoginViewController.h"

@interface HomeViewController : BaseViewController <UICheckBoxGroupDelegate>

@property (nonatomic, retain) NSString *homeURL;
@property (nonatomic, retain) NSString *hotURL;
@property (nonatomic, retain) NSString *classURL;


@end
